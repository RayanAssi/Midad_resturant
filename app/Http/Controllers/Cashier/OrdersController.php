<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('cashier.orders.index', compact('orders'));
    }

    public function create()
    {
        $menuItems = MenuItem::all();

        return view('cashier.orders.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'type' => 'required|in:dine_in,take_out,delivery',
            'table_no' => 'required_if:type,dine_in|nullable|string',
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

            $total = $order->orderItems()->sum('subtotal');
            $order->update(['total_amount' => $total]);

            DB::commit();

            return redirect()
                ->route('cashier.orders.index')
                ->with('flashMessage', 'Order created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load('items.menuItem', 'user');
        return view('cashier.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('orderItems.menuItem');
        $menuItems = MenuItem::all();
        

        return view('cashier.orders.edit', compact('order', 'menuItems'));
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [

            'type' => 'required|in:dine_in,take_out,delivery',
            'table_no' => 'required_if:type,dine_in|nullable|string',
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

            $order->update([
                
                'type' => $request->type,
                'table_no' => $request->table_no,
                'address' => $request->address,
                'notes' => $request->notes,
            ]);

            $order->orderItems()->delete();

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

            $total = $order->orderItems()->sum('subtotal');
            $order->update(['total_amount' => $total]);

            DB::commit();

            return redirect()
                ->route('cashier.orders.show', $order)
                ->with('flashMessage', 'Order updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('cashier.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}