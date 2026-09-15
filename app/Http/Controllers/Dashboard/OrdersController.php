<?php

namespace App\Http\Controllers;

use App\Models\Orders;
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
     * عرض قائمة كل الطلبات مع الفلترة والبحث
     */
    public function index(Request $request)
    {
        $query = Orders::with(['user', 'orderItems.menuItem', 'invoice']);

        // فلترة حسب النوع
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // فلترة حسب التاريخ
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        // البحث برقم الطاولة أو العنوان
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('table_no', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * عرض فورم إنشاء طلب جديد (اختياري للـ API)
     */
    public function create()
    {
        $menuItems = MenuItem::all();
        $users = User::all();

        return response()->json([
            'success' => true,
            'menu_items' => $menuItems,
            'users' => $users
        ]);
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // إنشاء الطلب
            $order = Orders::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'table_no' => $request->table_no,
                'address' => $request->address,
                'notes' => $request->notes,
                'total_amount' => 0,
            ]);

            // إضافة عناصر الطلب
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // حساب المجموع وتحديث الطلب
            $total = $this->calculateOrderTotal($order);
            $order->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'data' => $order->load('orderItems.menuItem', 'user')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض تفاصيل طلب معين
     */
    public function show($id)
    {
        $order = Orders::with(['user', 'orderItems.menuItem', 'invoice'])
                       ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * عرض فورم تعديل الطلب (اختياري للـ API)
     */
    public function edit($id)
    {
        $order = Orders::with('orderItems')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $menuItems = MenuItem::all();

        return response()->json([
            'success' => true,
            'order' => $order,
            'menu_items' => $menuItems
        ]);
    }

    /**
     * تحديث بيانات الطلب
     */
    public function update(Request $request, $id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // تحديث بيانات الطلب
            $order->update($request->only(['type', 'table_no', 'address', 'notes']));

            // إذا في عناصر جديدة، نحذف القديمة ونضيف الجديدة
            if ($request->has('items')) {
                $order->orderItems()->delete();

                foreach ($request->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                // إعادة حساب المجموع
                $total = $this->calculateOrderTotal($order);
                $order->update(['total_amount' => $total]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الطلب بنجاح',
                'data' => $order->load('orderItems.menuItem', 'user')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف الطلب
     */
    public function destroy($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // حذف الفاتورة المرتبطة إذا موجودة
            if ($order->invoice) {
                $order->invoice->delete();
            }

            // حذف عناصر الطلب
            $order->orderItems()->delete();

            // حذف الطلب
            $order->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطلب بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // الفانكشنز الإضافية لإدارة المطعم
    // ============================================

    /**
     * حساب مجموع الطلب (بدون ضريبة)
     */
    private function calculateOrderTotal(Orders $order)
    {
        $order->load('orderItems.menuItem');

        $subtotal = $order->orderItems->sum(function ($item) {
            return $item->quantity * $item->menuItem->price;
        });

        return $subtotal;
    }

    /**
     * عرض حساب الفاتورة (بدون إنشاء)
     */
    public function calculateInvoice($id)
    {
        $order = Orders::with('orderItems.menuItem')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        $subtotal = $this->calculateOrderTotal($order);
        $taxRate = 0.15; // 15% ضريبة
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        return response()->json([
            'success' => true,
            'data' => [
                'order_id' => $order->id,
                'items' => $order->orderItems->map(function ($item) {
                    return [
                        'name' => $item->menuItem->name,
                        'price' => $item->menuItem->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->quantity * $item->menuItem->price,
                    ];
                }),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]
        ]);
    }

    /**
     * إنشاء فاتورة للطلب
     */
    public function createInvoice($id)
    {
        $order = Orders::with('orderItems.menuItem')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        // التحقق إذا الفاتورة موجودة مسبقاً
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
            $taxRate = 0.15;
            $tax = $subtotal * $taxRate;
            $total = $subtotal + $tax;

            $invoice = Invoices::create([
                'order_id' => $order->id,
                'total' => $total,
                'tax_number' => 'TAX-' . now()->format('Ymd') . '-' . $order->id,
            ]);

            // تحديث مجموع الطلب
            $order->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الفاتورة بنجاح',
                'data' => $invoice
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الفاتورة',
                'error' => $e->getMessage()
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

        $orders = Orders::with(['user', 'orderItems.menuItem'])
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
        $orders = Orders::with(['user', 'orderItems.menuItem', 'invoice'])
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
     * إحصائيات الطلبات للمدير
     */
    public function statistics()
    {
        $stats = [
            'total_orders' => Orders::count(),
            'today_orders' => Orders::whereDate('created_at', today())->count(),
            'total_revenue' => Orders::sum('total_amount'),
            'today_revenue' => Orders::whereDate('created_at', today())->sum('total_amount'),
            'orders_by_type' => [
                'dine_in' => Orders::where('type', 'dine_in')->count(),
                'take_out' => Orders::where('type', 'take_out')->count(),
                'delivery' => Orders::where('type', 'delivery')->count(),
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

        $orders = Orders::with(['orderItems.menuItem', 'invoice'])
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
        $orders = Orders::with(['user', 'orderItems.menuItem'])
                       ->where('table_no', $tableNo)
                       ->latest()
                       ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * نسخ طلب موجود (إعادة الطلب)
     */
    public function duplicateOrder($id)
    {
        $originalOrder = Orders::with('orderItems')->find($id);

        if (!$originalOrder) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // إنشاء طلب جديد بنفس البيانات
            $newOrder = Orders::create([
                'user_id' => $originalOrder->user_id,
                'type' => $originalOrder->type,
                'table_no' => $originalOrder->table_no,
                'address' => $originalOrder->address,
                'notes' => $originalOrder->notes,
                'total_amount' => $originalOrder->total_amount,
            ]);

            // نسخ العناصر
            foreach ($originalOrder->orderItems as $item) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'menu_item_id' => $item->menu_item_id,
                    'quantity' => $item->quantity,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم نسخ الطلب بنجاح',
                'data' => $newOrder->load('orderItems.menuItem')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء نسخ الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}