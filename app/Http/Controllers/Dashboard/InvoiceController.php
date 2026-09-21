<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order ID is required');
        }

        $order = Order::with(['orderItems.menuItem', 'user'])->find($orderId);

        if (!$order) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Order not found');
        }

        if ($order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice->id)
                ->with('error', 'Invoice already exists for this order');
        }

        $subtotal = $order->orderItems->sum('subtotal');
        $taxRate  = config('restaurant.tax_rate', 15);

        return view('admin.invoices.create', compact('order', 'subtotal', 'taxRate'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'        => 'required|exists:orders,id',
            'subtotal'        => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_rate'        => 'required|numeric|min:0|max:100',
            'notes'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            return back()->with('error', 'Order not found')->withInput();
        }

        if ($order->invoice) {
            return back()->with('error', 'Invoice already exists')->withInput();
        }

        try {
            DB::beginTransaction();

            $subtotal = (float) $request->subtotal;
            $discount = (float) ($request->discount_amount ?? 0);
            $taxRate  = (float) $request->tax_rate;

            $taxableAmount = $subtotal - $discount;
            $taxAmount     = $taxableAmount * ($taxRate / 100);
            $totalAmount   = $taxableAmount + $taxAmount;

            $invoice = Invoice::create([
                'invoice_number'  => 'INV-' . now()->format('Ymd') . '-' . $order->id,
                'order_id'        => $order->id,
                'subtotal'        => $subtotal,
                'discount_amount' => $discount,
                'tax_rate'        => $taxRate,
                'tax_amount'      => $taxAmount,
                'total_amount'    => $totalAmount,
                'tax_number'      => 'TAX-' . now()->format('Ymd') . '-' . $order->id,
                'created_by'      => Auth::id(),
                'notes'           => $request->notes,
            ]);

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()
                ->route('admin.invoices.show', $invoice->id)
                ->with('flashMessage', 'Invoice created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
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
