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
    public function create(Request $request)
    {

        $orders = Order::whereDoesntHave('invoice')
            ->latest()
            ->get();

        $selectedOrder = $request->order_id
            ? Order::find($request->order_id)
            : null;

        return view('employee.invoices.create', compact('orders', 'selectedOrder'));
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
