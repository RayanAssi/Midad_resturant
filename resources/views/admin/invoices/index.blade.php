<x-layouts.admin title="Invoices">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 to-orange-400">
                Invoices
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                {{ $invoices->total() }} total invoice{{ $invoices->total() !== 1 ? 's' : '' }}
            </p>
        </div>
    </div>

    {{-- ═══ Search & Filter Bar ═══ --}}
    <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-amber-500/20 rounded-2xl p-5 mb-6
                shadow-xl shadow-amber-900/10">

        <form method="GET" action="{{ route('admin.invoices.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-4">

            {{-- Search Input --}}
            <div class="md:col-span-5">
                <label class="flex items-center gap-2 text-amber-200/60 text-xs uppercase tracking-wider mb-2">
                    <x-lucide-search class="w-3.5 h-3.5" />
                    Search
                </label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Invoice #, Order #, Tax #..."
                       class="w-full px-4 py-2.5 rounded-lg bg-black/60 border-2 border-amber-500/30
                              text-amber-100 placeholder-amber-200/30
                              focus:border-amber-400 focus:outline-none transition-colors">
            </div>

            {{-- Date From --}}
            <div class="md:col-span-3">
                <label class="flex items-center gap-2 text-amber-200/60 text-xs uppercase tracking-wider mb-2">
                    <x-lucide-calendar class="w-3.5 h-3.5" />
                    From
                </label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full px-4 py-2.5 rounded-lg bg-black/60 border-2 border-amber-500/30
                              text-amber-100 focus:border-amber-400 focus:outline-none
                              transition-colors">
            </div>

            {{-- Date To --}}
            <div class="md:col-span-3">
                <label class="flex items-center gap-2 text-amber-200/60 text-xs uppercase tracking-wider mb-2">
                    <x-lucide-calendar class="w-3.5 h-3.5" />
                    To
                </label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full px-4 py-2.5 rounded-lg bg-black/60 border-2 border-amber-500/30
                              text-amber-100 focus:border-amber-400 focus:outline-none
                              transition-colors">
            </div>

            {{-- Buttons --}}
            <div class="md:col-span-1 flex items-end gap-2">
                <button type="submit"
                        title="Search"
                        class="p-2.5 rounded-lg bg-gradient-to-r from-amber-600 to-amber-800
                               hover:from-amber-500 hover:to-amber-700
                               text-white transition-all">
                    <x-lucide-search class="w-5 h-5" />
                </button>
            </div>

        </form>

        {{-- Active Filters --}}
        @if(request('search') || request('date_from') || request('date_to'))
            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-amber-500/20 flex-wrap">
                <span class="text-amber-200/60 text-xs uppercase tracking-wider">Active filters:</span>

                @if(request('search'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg
                                 bg-amber-500/10 border border-amber-400/30
                                 text-amber-200 text-xs">
                        <x-lucide-search class="w-3 h-3" />
                        "{{ request('search') }}"
                    </span>
                @endif

                @if(request('date_from'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg
                                 bg-blue-500/10 border border-blue-400/30
                                 text-blue-200 text-xs">
                        <x-lucide-calendar class="w-3 h-3" />
                        From: {{ request('date_from') }}
                    </span>
                @endif

                @if(request('date_to'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg
                                 bg-blue-500/10 border border-blue-400/30
                                 text-blue-200 text-xs">
                        <x-lucide-calendar class="w-3 h-3" />
                        To: {{ request('date_to') }}
                    </span>
                @endif

                <a href="{{ route('admin.invoices.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg
                          bg-red-500/10 border border-red-400/30
                          text-red-300 text-xs
                          hover:bg-red-500/20 transition-all">
                    <x-lucide-x class="w-3 h-3" />
                    Clear
                </a>
            </div>
        @endif

    </div>

    @php
        $headers = ['Invoice', 'Order', 'Subtotal', 'Discount', 'Tax', 'Total', 'Date', 'Actions'];

        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.invoices.show', $invoice) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>
                <a href="{{ route('admin.invoices.edit', $invoice) }}"
                   title="Edit"
                   class="p-2 rounded-lg border border-blue-400/40 bg-blue-500/10
                          text-blue-300 hover:bg-blue-500/20 hover:border-blue-400/70
                          transition-all">
                    <x-lucide-edit class="w-4 h-4" />
                </a>
                <form action="{{ route('admin.invoices.destroy', $invoice) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this invoice?');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            title="Delete"
                            class="p-2 rounded-lg border border-red-400/40 bg-red-500/10
                                   text-red-300 hover:bg-red-500/20 hover:border-red-400/70
                                   transition-all">
                        <x-lucide-trash class="w-4 h-4" />
                    </button>
                </form>
            </div>
        BLADE;

        $rows = $invoices->map(function ($invoice) use ($actionsTemplate) {

            $order = $invoice->order_id
                ? '<span class="text-amber-200/70">' . $invoice->order_id . '</span>'
                : '<span class="text-amber-200/30">—</span>';

            $discount = $invoice->discount_amount > 0
                ? '<span class="text-red-300/80"> ' . number_format($invoice->discount_amount, 2) . '</span>'
                : '<span class="text-amber-200/30">—</span>';

            $tax = $invoice->tax_amount > 0
                ? '<span class="text-blue-300/80">' . number_format($invoice->tax_amount, 2)
                    . ' <small>(' . $invoice->tax_rate . '%)</small></span>'
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
        })->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="No invoices match your search">
        <x-slot:footer>
            <x-pagination :paginator="$invoices" />
        </x-slot:footer>
    </x-table>

</x-layouts.admin>