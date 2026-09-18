@php
    $menuItemsJson = [];
    foreach ($menuItems as $m) {
        $menuItemsJson[] = [
            'id'    => $m->id,
            'name'  => $m->name ?? 'Unnamed',
            'price' => (float) ($m->price ?? 0),
        ];
    }
@endphp

<x-layouts.admin title="New Order">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                        border-b-2 border-red-800/50">
                <h2 class="text-2xl font-black text-amber-100">New Order</h2>
                <p class="text-amber-200/60 text-sm mt-1">Fill in the details below</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.orders.store') }}" method="POST" id="order-form" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <x-form.select
                            name="user_id"
                            label="User"
                            :selected="old('user_id')"
                            :option="$users->pluck('name', 'id')->toArray()"
                            placeholder="Select user..."
                        />

                        <x-form.select
                            name="type"
                            label="Order Type"
                            :selected="old('type')"
                            :option="[
                                'dine_in'  => 'Dine In',
                                'take_out' => 'Take Out',
                                'delivery' => 'Delivery',
                            ]"
                            placeholder="Select type..."
                        />

                        <x-form.input
                            name="table_no"
                            label="Table No."
                            placeholder="e.g. 5"
                            :value="old('table_no')"
                        />

                        <x-form.input
                            name="address"
                            label="Address"
                            placeholder="For delivery only"
                            :value="old('address')"
                        />
                    </div>

                    <x-form.input
                        name="notes"
                        label="Notes"
                        placeholder="Any additional notes..."
                        :value="old('notes')"
                    />

                    <div class="border-t-2 border-red-800/30 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-black text-amber-100 flex items-center gap-2">
                                <span>🍽️</span>
                                Items
                            </h3>
                            <button type="button"
                                    onclick="addItemRow()"
                                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 to-amber-700
                                           hover:from-amber-500 hover:to-amber-600
                                           text-white font-bold shadow-lg shadow-amber-900/30
                                           transition-all hover:scale-105 active:scale-95 text-sm">
                                + Add Item
                            </button>
                        </div>

                        @error('items')
                            <p class="mb-3 text-sm text-red-400">⚠ {{ $message }}</p>
                        @enderror

                        @error('items.*.menu_item_id')
                            <p class="mb-3 text-sm text-red-400">⚠ {{ $message }}</p>
                        @enderror

                        <div id="items-container" class="space-y-3"></div>

                        <p id="empty-message" class="text-center text-amber-200/50 py-6 text-sm">
                            No items added yet. Click "Add Item" to start.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                                border-2 border-amber-500/40 shadow-lg shadow-amber-900/20">
                        <h3 class="text-lg font-black text-amber-100 mb-4 flex items-center gap-2">
                            <span>💰</span>
                            Order Summary
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between text-amber-100">
                                <span class="font-bold">Subtotal:</span>
                                <span class="font-black text-amber-400" id="subtotal-display">0.00 SYP</span>
                            </div>
                            <div class="flex justify-between border-t-2 border-amber-500/30 pt-3">
                                <span class="font-black text-amber-100 text-lg">Total:</span>
                                <span class="font-black text-green-400 text-2xl" id="total-display">0.00 SYP</span>
                            </div>
                        </div>

                        <p class="text-xs text-amber-200/50 mt-3">
                            💡 Tax will be calculated on the invoice page
                        </p>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-800
                                       hover:from-red-500 hover:to-red-700
                                       text-amber-50 font-bold shadow-lg shadow-red-900/50
                                       transition-all hover:scale-105 active:scale-95">
                            💾 Save Order
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                           class="px-6 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-600/50
                                  text-amber-100 font-bold transition-all
                                  border border-gray-600/50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

<script>
    const menuItems = @json($menuItemsJson);
    const oldItems  = @json(old('items', []));

    console.log('MenuItems loaded:', menuItems);
    console.log('Old Items:', oldItems);

    let rowIndex = 0;

    function addItemRow(selectedId = '', qty = 1) {
        const container    = document.getElementById('items-container');
        const emptyMessage = document.getElementById('empty-message');

        if (!container) return;

        emptyMessage.style.display = 'none';

        const index = rowIndex++;

        let optionsHtml = '';
        if (menuItems.length === 0) {
            optionsHtml = '<option value="" disabled>⚠️ No items available</option>';
        } else {
            menuItems.forEach(function (item) {
                const selected = (item.id == selectedId) ? ' selected' : '';
                optionsHtml += '<option value="' + item.id + '" data-price="' + item.price + '"' + selected + '>'
                             + item.name + ' — ' + item.price + ' SYP'
                             + '</option>';
            });
        }

        const row = document.createElement('div');
        row.className = 'item-row grid grid-cols-12 gap-2 items-center p-3 rounded-xl bg-gray-900/60 border border-red-800/30';

        row.innerHTML = `
            <div class="col-span-7">
                <select name="items[${index}][menu_item_id]"
                        required
                        onchange="updateTotals()"
                        class="w-full px-3 py-2.5 bg-gradient-to-br from-gray-900 to-gray-800
                               border-2 border-red-800/50 rounded-xl text-amber-50
                               focus:outline-none focus:border-amber-400 transition">
                    <option value="" disabled ${!selectedId ? 'selected' : ''}>Select item...</option>
                    ${optionsHtml}
                </select>
            </div>

            <div class="col-span-3">
                <input type="number"
                       name="items[${index}][quantity]"
                       value="${qty}"
                       min="1"
                       required
                       oninput="updateTotals()"
                       placeholder="Qty"
                       class="w-full px-3 py-2.5 bg-gradient-to-br from-gray-900 to-gray-800
                              border-2 border-red-800/50 rounded-xl text-amber-50 text-center
                              focus:outline-none focus:border-amber-400 transition">
            </div>

            <div class="col-span-2 flex justify-end">
                <button type="button"
                        onclick="removeItemRow(this)"
                        class="w-10 h-10 rounded-xl bg-red-500/20 hover:bg-red-500/40
                               border border-red-500/40 text-red-300 font-bold
                               flex items-center justify-center transition-all
                               hover:scale-110 active:scale-95"
                        title="Remove">
                    ✕
                </button>
            </div>
        `;

        container.appendChild(row);
        updateTotals();
    }

    function removeItemRow(button) {
        button.closest('.item-row').remove();

        const container    = document.getElementById('items-container');
        const emptyMessage = document.getElementById('empty-message');

        if (container.children.length === 0) {
            emptyMessage.style.display = 'block';
        }

        updateTotals();
    }

    function updateTotals() {
        let subtotal = 0;

        document.querySelectorAll('.item-row').forEach(function (row) {
            const select = row.querySelector('select');
            const input  = row.querySelector('input[type="number"]');
            const option = select.options[select.selectedIndex];
            const qty    = parseInt(input.value) || 0;

            if (option && option.dataset.price) {
                subtotal += parseFloat(option.dataset.price) * qty;
            }
        });

        document.getElementById('subtotal-display').textContent = subtotal.toFixed(2) + ' SYP';
        document.getElementById('total-display').textContent    = subtotal.toFixed(2) + ' SYP';
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (oldItems && oldItems.length > 0) {
            oldItems.forEach(function (item) {
                addItemRow(item.menu_item_id || '', item.quantity || 1);
            });
        } else {
            addItemRow();
        }
    });
</script>