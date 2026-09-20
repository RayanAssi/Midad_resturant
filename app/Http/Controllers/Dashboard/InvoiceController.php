<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['order', 'creator']);

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

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['order', 'creator']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'discount_amount' => 'nullable|numeric|min:0',
            'notes'           => 'nullable|string',
        ]);

        $taxRate   = config('restaurant.tax_rate') / 100;
        $subtotal  = $invoice->subtotal;
        $discount  = $validated['discount_amount'] ?? 0;
        $taxAmount = ($subtotal - $discount) * $taxRate;
        $total     = $subtotal - $discount + $taxAmount;

        $invoice->update([
            'discount_amount' => $discount,
            'tax_rate'        => $taxRate * 100,
            'tax_amount'      => $taxAmount,
            'total_amount'    => $total,
            'notes'           => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'updated invoice successfully');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'deleted invoice successfully');
    }
}
