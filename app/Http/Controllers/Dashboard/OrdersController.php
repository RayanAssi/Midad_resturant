<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Invoices;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * عرض قائمة كل الطلبات
     */
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

        $stats = [
            'total'   => Order::count(),
            'today'   => Order::whereDate('created_at', today())->count(),
            'revenue' => Order::sum('total_amount'),
            'average' => Order::avg('total_amount') ?? 0,
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض فورم إنشاء طلب جديد
     */
    public function create()
    {
        $menuItems = MenuItem::all();
        $users = User::all();

        return view('admin.orders.create', compact('menuItems', 'users'));
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
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
                'user_id'      => $request->user_id,
                'type'         => $request->type,
                'table_no'     => $request->table_no,
                'address'      => $request->address,
                'notes'        => $request->notes,
                'total_amount' => 0,
            ]);

            foreach ($request->items as $item) {
                $menuItemId = $item['menu_item_id'] ?? null;

                if (!$menuItemId) {
                    throw new \Exception('لم يتم تحديد الصنف في أحد الصفوف');
                }

                $menuItem = MenuItem::find($menuItemId);

                if (!$menuItem) {
                    throw new \Exception('الصنف غير موجود: ' . $menuItemId);
                }

                $quantity = (int) $item['quantity'];

                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $menuItemId,
                    'quantity'     => $quantity,
                    'price'        => $menuItem->price,
                    'subtotal'     => $quantity * $menuItem->price,
                ]);
            }

            $total = $this->calculateOrderTotal($order);
            $order->update(['total_amount' => $total]);

            DB::commit();

            return redirect()
                ->route('orders.index')
                ->with('flashMessage', 'تم إنشاء الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * عرض تفاصيل طلب
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.menuItem', 'invoice'])->find($id);

        if (!$order) {
            return redirect()->route('orders.index')
                ->with('error', 'الطلب غير موجود');
        }

        return view('admin.orders.show', compact('order'));
    }

    /**
     * عرض فورم تعديل الطلب
     */
    public function edit($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return redirect()->route('orders.index')
                ->with('error', 'الطلب غير موجود');
        }

        $menuItems = MenuItem::all();

        return view('admin.orders.edit', compact('order', 'menuItems'));
    }

    /**
     * تحديث الطلب
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('orders.index')
                ->with('error', 'الطلب غير موجود');
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
                        'order_id'     => $order->id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity'     => $quantity,
                        'price'        => $menuItem->price,
                        'subtotal'     => $quantity * $menuItem->price,
                    ]);
                }

                $total = $this->calculateOrderTotal($order);
                $order->update(['total_amount' => $total]);
            }

            DB::commit();

            return redirect()
                ->route('orders.index')
                ->with('flashMessage', 'تم تحديث الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * حذف الطلب
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('orders.index')
                ->with('error', 'الطلب غير موجود');
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
                ->route('orders.index')
                ->with('flashMessage', 'تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حساب مجموع الطلب (من order_items المخزّنة، مش من menu_items الحالية)
     */
    private function calculateOrderTotal(Order $order)
    {
        $order->load('orderItems');

        return $order->orderItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * عرض حساب الفاتورة (بدون إنشاء)
     */
    public function calculateInvoice($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $subtotal = $this->calculateOrderTotal($order);
        $taxRate  = 0.15;
        $tax      = $subtotal * $taxRate;
        $total    = $subtotal + $tax;

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $order->id,
                'items' => $order->orderItems->map(function ($item) {
                    return [
                        'name'     => $item->menuItem->name,
                        'price'    => $item->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->quantity * $item->price,
                    ];
                }),
                'subtotal' => $subtotal,
                'tax'      => $tax,
                'total'    => $total,
            ]
        ]);
    }

    /**
     * إنشاء فاتورة للطلب
     */
    public function createInvoice($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        if ($order->invoice) {
            return response()->json([
                'success' => false,
                'message' => 'الفاتورة موجودة مسبقاً لهذا الطلب',
                'data' => $order->invoice
            ], 400);
        }

        try {
            DB::beginTransaction();

            $subtotal = $this->calculateOrderTotal($order);
            $taxRate  = 0.15;
            $tax      = $subtotal * $taxRate;
            $total    = $subtotal + $tax;

            $invoice = Invoices::create([
                'order_id'   => $order->id,
                'total'      => $total,
                'tax_number' => 'TAX-' . now()->format('Ymd') . '-' . $order->id,
            ]);

            $order->update(['total_amount' => $subtotal]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الفاتورة بنجاح',
                'data'    => $invoice
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الفاتورة',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض الطلبات حسب النوع
     */
    public function filterByType($type)
    {
        $validTypes = ['dine_in', 'take_out', 'delivery'];

        if (!in_array($type, $validTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'نوع طلب غير صحيح'
            ], 400);
        }

        $orders = Order::with(['user', 'orderItems.menuItem'])
            ->where('type', $type)
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * عرض طلبات اليوم
     */
    public function todayOrders()
    {
        $orders = Order::with(['user', 'orderItems.menuItem', 'invoice'])
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        $totalSales = $orders->sum('total_amount');

        return response()->json([
            'success' => true,
            'data' => [
                'orders' => $orders,
                'count' => $orders->count(),
                'total_sales' => $totalSales,
            ]
        ]);
    }

    /**
     * إحصائيات الطلبات
     */
    public function statistics()
    {
        $stats = [
            'total_orders'   => Order::count(),
            'today_orders'   => Order::whereDate('created_at', today())->count(),
            'total_revenue'  => Order::sum('total_amount'),
            'today_revenue'  => Order::whereDate('created_at', today())->sum('total_amount'),
            'orders_by_type' => [
                'dine_in'  => Order::where('type', 'dine_in')->count(),
                'take_out' => Order::where('type', 'take_out')->count(),
                'delivery' => Order::where('type', 'delivery')->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * عرض الطلبات حسب المستخدم
     */
    public function ordersByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير موجود'
            ], 404);
        }

        $orders = Order::with(['orderItems.menuItem', 'invoice'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'user' => $user->name,
            'data' => $orders
        ]);
    }

    /**
     * عرض الطلبات حسب رقم الطاولة
     */
    public function ordersByTable($tableNo)
    {
        $orders = Order::with(['user', 'orderItems.menuItem'])
            ->where('table_no', $tableNo)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * نسخ طلب موجود
     */
    public function duplicateOrder($id)
    {
        $originalOrder = Order::with('orderItems')->find($id);

        if (!$originalOrder) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $newOrder = Order::create([
                'user_id'      => $originalOrder->user_id,
                'type'         => $originalOrder->type,
                'table_no'     => $originalOrder->table_no,
                'address'      => $originalOrder->address,
                'notes'        => $originalOrder->notes,
                'total_amount' => 0,
            ]);

            foreach ($originalOrder->orderItems as $item) {
                OrderItem::create([
                    'order_id'     => $newOrder->id,
                    'menu_item_id' => $item->menu_item_id,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                    'subtotal'     => $item->subtotal,
                ]);
            }

            $newOrder->load('orderItems');
            $total = $newOrder->orderItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            $newOrder->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم نسخ الطلب بنجاح',
                'data'    => $newOrder->load('orderItems.menuItem')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء نسخ الطلب',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}