<x-layouts.employee title="My Invoices">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                My Invoices
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Today:
                <span class="text-amber-200">
                    {{ \App\Models\Invoice::where('created_by', auth()->id())->whereDate('created_at', today())->count() }}
                </span>
                invoices
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            

            {{-- ═══ Filter Form ═══ --}}
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="px-4 py-2 rounded-lg bg-black/40 border-2 border-amber-800/40
                           text-amber-100 placeholder-amber-200/30
                           focus:outline-none focus:border-amber-600/60 transition-colors" />

                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="px-4 py-2 rounded-lg bg-black/40 border-2 border-amber-800/40
                           text-amber-100 focus:outline-none focus:border-amber-600/60" />

                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="px-4 py-2 rounded-lg bg-black/40 border-2 border-amber-800/40
                           text-amber-100 focus:outline-none focus:border-amber-600/60" />

                <button type="submit"
                    class="px-5 py-2 rounded-lg
                           bg-gradient-to-r from-amber-600 to-amber-800
                           hover:from-amber-500 hover:to-amber-700
                           text-white font-bold
                           shadow-lg shadow-amber-900/50 transition-all">
                    Filter
                </button>

                @if (request('search') || request('date_from') || request('date_to'))
                    <a href="{{ route('employee.invoices.index') }}"
                        class="px-4 py-2 rounded-lg bg-black/40 border-2 border-amber-800/40
                               text-amber-100 font-bold
                               hover:border-amber-600/60 transition-all">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    @php
        $headers = ['Invoice', 'Order', 'Subtotal', 'Discount', 'Tax', 'Total', 'Date', 'Actions'];

        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('employee.invoices.show', $invoice) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>

                {{-- زر Print --}}
                <button type="button"
                        onclick="window.open('{{ route('employee.invoices.show', $invoice) }}', '_blank')"
                        title="Print"
                        class="p-2 rounded-lg border border-emerald-400/40 bg-emerald-500/10
                               text-emerald-300 hover:bg-emerald-500/20 hover:border-emerald-400/70
                               transition-all">
                    <x-lucide-printer class="w-4 h-4" />
                </button>
            </div>
        BLADE;

        $rows = $invoices
            ->map(function ($invoice) use ($actionsTemplate) {
                $order = $invoice->order_id
                    ? '<span class="text-amber-200/70">#' . $invoice->order_id . '</span>'
                    : '<span class="text-amber-200/30">—</span>';

                $discount = $invoice->discount_amount > 0
                    ? '<span class="text-red-300/80">' . number_format($invoice->discount_amount, 2) . '</span>'
                    : '<span class="text-amber-200/30">—</span>';

                $tax = $invoice->tax_amount > 0
                    ? '<span class="text-blue-300/80">' .
                        number_format($invoice->tax_amount, 2) .
                        ' <small>(' . $invoice->tax_rate . '%)</small></span>'
                    : '<span class="text-amber-200/30">—</span>';

                $actions = \Illuminate\Support\Facades\Blade::render($actionsTemplate, ['invoice' => $invoice]);

                return [
                    '<span class="font-bold text-amber-200">' . $invoice->invoice_number . '</span>',
                    $order,
                    '<span class="text-amber-100">' . number_format($invoice->subtotal, 2) . ' ' . config('restaurant.currency') . '</span>',
                    $discount,
                    $tax,
                    '<span class="font-bold text-amber-100">' . number_format($invoice->total_amount, 2) . ' ' . config('restaurant.currency') . '</span>',
                    '<span class="text-amber-200/60">' . $invoice->created_at->format('Y-m-d H:i') . '</span>',
                    $actions,
                ];
            })
            ->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="No invoices found">
        <x-slot:footer>
            <x-pagination :paginator="$invoices" />
        </x-slot:footer>
    </x-table>

</x-layouts.employee>