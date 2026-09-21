<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.menuItem', 'invoice']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('table_no', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);

        // Stats
        $stats = [
            'total' => Order::count(),
            'today' => Order::whereDate('created_at', today())->count(),
            'revenue' => Order::sum('total_amount'),
            'average' => Order::avg('total_amount') ?? 0,
        ];

        // ✅ Counts لكل نوع (للفلتر tabs)
        $typeCounts = [
            'dine_in' => Order::where('type', 'dine_in')->count(),
            'take_out' => Order::where('type', 'take_out')->count(),
            'delivery' => Order::where('type', 'delivery')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'typeCounts'));
    }

    
    public function create()
    {
        $menuItems = MenuItem::all();

        return view('admin.orders.create', compact('menuItems'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:dine_in,take_out,delivery',
            'table_no' => 'required_if:type,dine_in|nullable|string|max:10|regex:/^[A-Za-z0-9\-]+$/',
            'address' => 'required_if:type,delivery|nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'type' => $request->type,
                'table_no' => $request->table_no,
                'address' => $request->address,
                'notes' => $request->notes,
                'total_amount' => 0,
            ]);

            foreach ($request->items as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                $quantity = (int) $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'price' => $menuItem->price,
                    'subtotal' => $quantity * $menuItem->price,
                ]);
            }

            $total = $this->calculateOrderTotal($order);
            $order->update(['total_amount' => $total]);

            DB::commit();

            return redirect()
                ->route('admin.invoices.create', ['order_id' => $order->id])
                ->with('flashMessage', 'Order created. Now create the invoice.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.menuItem', 'invoice'])->find($id);

        if (!$order) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }

        return view('admin.orders.show', compact('order'));
    }

    
    public function edit($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }

        $menuItems = MenuItem::all();

        return view('admin.orders.edit', compact('order', 'menuItems'));
    }

    
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }

        $validator = Validator::make($request->all(), [
            'type' => 'sometimes|in:dine_in,take_out,delivery',
            'table_no' => 'nullable|string',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'sometimes|array|min:1',
            'items.*.menu_item_id' => 'required_with:items|exists:menu_items,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $order->update($request->only(['type', 'table_no', 'address', 'notes']));

            if ($request->has('items')) {
                $order->orderItems()->delete();

                foreach ($request->items as $item) {
                    $menuItem = MenuItem::find($item['menu_item_id']);
                    $quantity = (int) $item['quantity'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity' => $quantity,
                        'price' => $menuItem->price,
                        'subtotal' => $quantity * $menuItem->price,
                    ]);
                }

                $total = $this->calculateOrderTotal($order);
                $order->update(['total_amount' => $total]);
            }

            DB::commit();

            return redirect()
                ->route('admin.orders.index')
                ->with('flashMessage', 'Order updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }

        try {
            DB::beginTransaction();

            if ($order->invoice) {
                $order->invoice->delete();
            }

            $order->orderItems()->delete();
            $order->delete();

            DB::commit();

            return redirect()
                ->route('admin.orders.index')
                ->with('flashMessage', 'Order deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    
    private function calculateOrderTotal(Order $order)
    {
        $order->load('orderItems');

        return $order->orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}