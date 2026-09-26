<x-layouts.admin title="Edit Invoice">

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-black text-transparent bg-clip-text
                   bg-gradient-to-r from-amber-300 to-orange-400 mb-6">
            Edit Invoice {{ $invoice->invoice_number }}
        </h1>

        <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST"
              class="bg-black/40 border border-amber-500/20 rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')

            {{-- Subtotal --}}
            <div>
                <label class="block text-amber-200 mb-2 font-bold">Subtotal</label>
                <input type="text" disabled
                       value="{{ number_format($invoice->subtotal, 2) }} {{ config('restaurant.currency') }}"
                       class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/20
                              text-amber-200/60 cursor-not-allowed">
            </div>

            {{-- Discount --}}
            <div>
                <label class="block text-amber-200 mb-2 font-bold">Discount</label>
                <input type="number" name="discount_amount" step="0.01" min="0"
                       value="{{ old('discount_amount', $invoice->discount_amount) }}"
                       class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/30
                              text-amber-100 focus:border-amber-400 focus:outline-none">
                @error('discount_amount')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tax info --}}
            <div class="bg-blue-500/10 border border-blue-400/30 rounded-lg p-4">
                <p class="text-blue-300 text-sm">
                    💡 Current tax rate: <strong>{{ config('restaurant.tax_rate') }}%</strong>
                    — calculated automatically on save
                </p>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-amber-200 mb-2 font-bold">Notes</label>
                <textarea name="notes" rows="3"
                          class="w-full px-4 py-2.5 rounded-lg bg-black/60 border border-amber-500/30
                                 text-amber-100 focus:border-amber-400 focus:outline-none">{{ old('notes', $invoice->notes) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-red-600 to-red-800
                               hover:from-red-500 hover:to-red-700 text-amber-50 font-bold
                               shadow-lg shadow-red-900/50 transition-all">
                    Save Changes
                </button>
                <a href="{{ route('admin.invoices.index') }}"
                   class="px-6 py-2.5 rounded-lg bg-black/40 border border-amber-500/30
                          text-amber-200 hover:border-amber-400/60">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</x-layouts.admin>