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
        // الطلبات يلي ما إلها فاتورة بعد
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
        $validated = $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes'           => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->invoice) {
            return back()->with('error', 'هذا الطلب له فاتورة بالفعل');
        }

        // الحسابات
        $taxRate   = config('restaurant.tax_rate') / 100;
        $subtotal  = $order->total_amount;
        $discount  = $validated['discount_amount'] ?? 0;
        $taxAmount = ($subtotal - $discount) * $taxRate;
        $total     = $subtotal - $discount + $taxAmount;

        DB::beginTransaction();

        try {
            // 1. أنشئ الفاتورة برقم مؤقت
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

            // 2. ولّد الرقم النهائي
            $invoiceNumber = config('restaurant.invoice_prefix')
                . '-' . now()->format('Y')
                . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);

            // 3. حدّث الفاتورة
            $invoice->update([
                'invoice_number' => $invoiceNumber,
                'tax_number'     => 'TAX-' . $invoiceNumber,
            ]);

            DB::commit();

          return redirect()
    ->route('employee.invoices.create', ['order_id' => $order->id])
    ->with('invoice_created', $invoiceNumber)
    ->with('invoice_id', $invoice->id);   // ✅ ضيف هذا
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['order', 'creator']);
        return view('employee.invoices.show', compact('invoice'));
    }
}
