<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
{
    $query = Invoice::with(['order', 'creator'])
        ->where('created_by', Auth::id());   

    // ═══ Search ═══
    if ($search = $request->search) {
        $query->where(function ($q) use ($search) {
            $q->where('invoice_number', 'like', "%{$search}%")
              ->orWhere('order_id', 'like', "%{$search}%")
              ->orWhere('tax_number', 'like', "%{$search}%");
        });
    }

    // ═══ Date From ═══
    if ($dateFrom = $request->date_from) {
        $query->whereDate('created_at', '>=', $dateFrom);
    }

    // ═══ Date To ═══
    if ($dateTo = $request->date_to) {
        $query->whereDate('created_at', '<=', $dateTo);
    }

    $invoices = $query->latest()->paginate(15)->withQueryString();

    return view('employee.invoices.index', compact('invoices'));
}
    public function create(Request $request)
{
    $orderId = $request->query('order_id');

    
    if (!$orderId) {
        return redirect()
            ->route('employee.orders.index')
            ->with('error', 'يجب اختيار طلب أولاً لإصدار فاتورة');
    }

    
    $selectedOrder = Order::with(['orderItems.menuItem', 'user'])->find($orderId);

    if (!$selectedOrder) {
        return redirect()
            ->route('employee.orders.index')
            ->with('error', 'الطلب غير موجود');
    }

    
    if ($selectedOrder->invoice) {
        return redirect()
            ->route('employee.invoices.show', $selectedOrder->invoice->id)
            ->with('error', 'هذا الطلب له فاتورة بالفعل');
    }

    return view('employee.invoices.create', compact('selectedOrder'));
}

   public function store(Request $request)
{
    // ═══ 1) Validation الأساسي ═══
    $validated = $request->validate([
        'order_id'        => 'required|exists:orders,id',
        'discount_amount' => 'nullable|numeric|min:0|max:9999999.99',
        'notes'           => 'nullable|string|max:500',
    ]);

    // ═══ 2) جيب الـ order مرة وحدة ═══
    $order = Order::findOrFail($validated['order_id']);

    // ═══ 3) تحقق: ما في فاتورة سابقة ═══
    if ($order->invoice) {
        return back()->with('error', 'هذا الطلب له فاتورة بالفعل');
    }

    // ═══ 4) الحسابات ═══
    $subtotal = (float) $order->total_amount;
    $discount = (float) ($validated['discount_amount'] ?? 0);

    // ═══ 5) Validation إضافي: discount <= subtotal ═══
    if ($discount > $subtotal) {
        return back()
            ->withErrors([
                'discount_amount' => 'الخصم لا يمكن أن يكون أكبر من المجموع الفرعي (' . number_format($subtotal, 2) . ' SYP)'
            ])
            ->withInput();
    }

    // ═══ 6) الحسابات النهائية ═══
    $taxRate   = (float) config('restaurant.tax_rate') / 100;
    $taxAmount = ($subtotal - $discount) * $taxRate;
    $total     = $subtotal - $discount + $taxAmount;

    // ═══ 7) حماية إضافية: total مو سالب ═══
    if ($total < 0) {
        return back()
            ->withErrors(['discount_amount' => 'الخصم كبير جداً — الإجمالي لا يمكن أن يكون سالب'])
            ->withInput();
    }

    // ═══ 8) إنشاء الفاتورة ═══
    DB::beginTransaction();

    try {
        $invoice = Invoice::create([
            'invoice_number'  => 'TEMP-' . uniqid(),
            'order_id'        => $order->id,
            'subtotal'        => $subtotal,
            'discount_amount' => $discount,
            'tax_rate'        => $taxRate * 100,
            'tax_amount'      => $taxAmount,
            'total_amount'    => $total,
            'tax_number'      => null,
            'created_by'      => Auth::id(),
            'notes'           => $validated['notes'] ?? null,
        ]);

        $invoiceNumber = config('restaurant.invoice_prefix')
            . '-' . now()->format('Y')
            . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);

        $invoice->update([
            'invoice_number' => $invoiceNumber,
            'tax_number'     => 'TAX-' . $invoiceNumber,
        ]);

        DB::commit();

        return redirect()
            ->route('employee.invoices.show', $invoice->id)
            ->with('flashMessage', 'Invoice issued successfully: ' . $invoiceNumber);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'خطأ: ' . $e->getMessage())->withInput();
    }
}

    public function show(Invoice $invoice)
    {
        $invoice->load(['order', 'creator']);
        return view('employee.invoices.show', compact('invoice'));
    }
}
