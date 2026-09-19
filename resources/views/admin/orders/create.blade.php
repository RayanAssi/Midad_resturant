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
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- ============ Progress Steps ============ --}}
        <div class="flex items-center justify-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white font-black
                            flex items-center justify-center shadow-lg shadow-amber-900/50">
                    1
                </div>
                <span class="text-amber-100 font-bold">Order Details</span>
            </div>
            <div class="w-16 h-0.5 bg-amber-500/30"></div>
            <div class="flex items-center gap-2 opacity-50">
                <div class="w-8 h-8 rounded-full bg-gray-700 text-amber-200 font-black
                            flex items-center justify-center">
                    2
                </div>
                <span class="text-amber-200/60 font-bold">Create Invoice</span>
            </div>
        </div>

        {{-- ============ Main Grid: Menu (Left) + Order Info (Right) ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ============ Menu Section (2 cols) ============ --}}
            <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

                <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                            border-b-2 border-red-800/50 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-amber-100">Menu</h2>
                        <p class="text-amber-200/60 text-sm mt-1">Click an item to add it to the cart</p>
                    </div>

                    {{-- Search --}}
                    <div class="relative">
                        <input type="text" id="menu-search"
                               placeholder="Search menu..."
                               class="w-48 px-4 py-2 pl-10 rounded-xl bg-black/40
                                      border border-red-800/30 text-amber-100 text-sm
                                      placeholder-amber-200/30
                                      focus:outline-none focus:border-amber-400 transition">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-amber-200/40">🔍</span>
                    </div>
                </div>

                <div class="p-6">
                    @if(count($menuItemsJson) === 0)
                        <p class="text-center text-amber-200/60 py-12">No menu items available</p>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="menu-grid">
                            @foreach($menuItems as $item)
                                <button type="button"
                                        data-menu-id="{{ $item->id }}"
                                        data-menu-name="{{ strtolower($item->name) }}"
                                        onclick="addToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})"
                                        class="menu-item-btn group p-4 rounded-xl bg-gradient-to-br from-gray-900 to-gray-800
                                               border-2 border-red-800/50 hover:border-amber-400
                                               transition-all hover:scale-105 active:scale-95 text-left">
                                    <p class="text-amber-100 font-bold truncate">{{ $item->name }}</p>
                                    <p class="text-amber-400 font-black text-lg mt-1">
                                        {{ number_format($item->price, 0) }}
                                        <span class="text-xs">SYP</span>
                                    </p>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============ Order Form (1 col) ============ --}}
            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-24 rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                            border-2 border-amber-500/40 shadow-2xl shadow-amber-900/20 overflow-hidden">

                    {{-- Header --}}
                    <div class="px-5 py-4 bg-gradient-to-r from-amber-900/60 via-amber-800/40 to-transparent
                                border-b-2 border-amber-700/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-amber-100">Current Order</h3>
                        <span id="cart-count"
                              class="px-3 py-1 rounded-full bg-amber-700 text-amber-50 text-xs font-bold">0</span>
                    </div>

                    {{-- Cart Items --}}
                    <div id="cart-items" class="max-h-[30vh] overflow-y-auto p-4 space-y-2">
                        <p class="text-center text-amber-200/40 text-sm py-8">
                            Cart is empty
                        </p>
                    </div>

                    {{-- Form --}}
                    <div class="px-5 py-4 border-t-2 border-amber-800/40
                                bg-gradient-to-r from-transparent to-amber-900/30">

                        {{-- Totals --}}
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-amber-500/30">
                            <span class="text-amber-100 text-sm font-black">TOTAL</span>
                            <span id="cart-total" class="text-2xl font-black text-green-400">0.00</span>
                        </div>

                        <form id="order-form"
                              action="{{ route('admin.orders.store') }}"
                              method="POST"
                              class="space-y-3">
                            @csrf

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

                            {{-- Table No. --}}
                            <div id="table-no-wrapper" class="hidden">
                                <x-form.input
                                    name="table_no"
                                    label="Table No."
                                    placeholder="e.g. 5"
                                    :value="old('table_no')"
                                />
                            </div>

                            {{-- Address --}}
                            <div id="address-wrapper" class="hidden">
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
                                placeholder="Any notes..."
                                :value="old('notes')"
                            />

                            <div id="hidden-items"></div>

                            <button type="submit"
                                    id="confirm-btn"
                                    disabled
                                    class="w-full py-3 rounded-xl font-black text-sm tracking-wide
                                           bg-gradient-to-r from-amber-600 to-amber-800
                                           hover:from-amber-500 hover:to-amber-700
                                           text-white shadow-lg shadow-amber-900/50
                                           transition-all disabled:opacity-40
                                           disabled:cursor-not-allowed
                                           flex items-center justify-center gap-2">
                                <span>Next: Create Invoice</span>
                                <span class="text-xl">→</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

<script>
    /* ============================================================
       Order Type → Toggle Table No. / Address
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect     = document.querySelector('select[name="type"]');
        const tableWrapper   = document.getElementById('table-no-wrapper');
        const addressWrapper = document.getElementById('address-wrapper');

        if (!typeSelect || !tableWrapper || !addressWrapper) return;

        const tableInput   = tableWrapper.querySelector('input[name="table_no"]');
        const addressInput = addressWrapper.querySelector('input[name="address"]');

        function toggleFields() {
            const type = typeSelect.value;

            tableWrapper.classList.add('hidden');
            addressWrapper.classList.add('hidden');
            if (tableInput)   tableInput.required   = false;
            if (addressInput) addressInput.required = false;

            if (type === 'dine_in') {
                tableWrapper.classList.remove('hidden');
                if (tableInput) tableInput.required = true;
            } else if (type === 'delivery') {
                addressWrapper.classList.remove('hidden');
                if (addressInput) addressInput.required = true;
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();
    });

    /* ============================================================
       Menu Search
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('menu-search');
        const menuButtons = document.querySelectorAll('.menu-item-btn');

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();

            menuButtons.forEach(btn => {
                const name = btn.dataset.menuName;
                btn.style.display = name.includes(term) ? '' : 'none';
            });
        });
    });

    /* ============================================================
       Cart
    ============================================================ */
    const cart = {};
    const menuItems = @json($menuItemsJson);

    function addToCart(id, name, price) {
        if (cart[id]) {
            cart[id].qty++;
        } else {
            cart[id] = { id: id, name: name, price: parseFloat(price), qty: 1 };
        }
        renderCart();
    }

    function removeFromCart(id) {
        delete cart[id];
        renderCart();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        cart[id].qty += delta;
        if (cart[id].qty <= 0) delete cart[id];
        renderCart();
    }

    function renderCart() {
        const itemsEl  = document.getElementById('cart-items');
        const countEl  = document.getElementById('cart-count');
        const totalEl  = document.getElementById('cart-total');
        const hiddenEl = document.getElementById('hidden-items');
        const btn      = document.getElementById('confirm-btn');

        const ids = Object.keys(cart);

        if (ids.length === 0) {
            itemsEl.innerHTML = '<p class="text-center text-amber-200/40 text-sm py-8">Cart is empty</p>';
            countEl.textContent = '0';
            totalEl.textContent = '0.00';
            hiddenEl.innerHTML = '';
            btn.disabled = true;
            return;
        }

        let subtotal = 0;
        let count = 0;
        let html = '';
        let hidden = '';

        ids.forEach(function (id, i) {
            const item = cart[id];
            const sub = item.price * item.qty;
            subtotal += sub;
            count += item.qty;

            html += `
                <div class="flex items-center justify-between gap-2
                            p-3 rounded-lg bg-black/40 border border-amber-800/30">
                    <div class="flex-1 min-w-0">
                        <p class="text-amber-100 text-sm font-bold truncate">${item.name}</p>
                        <p class="text-amber-300/70 text-xs">${item.price.toFixed(0)} × ${item.qty} = ${sub.toFixed(0)}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="changeQty(${id}, -1)"
                                class="w-7 h-7 rounded bg-red-900/60 hover:bg-red-800 text-amber-100 text-sm font-bold">−</button>
                        <button type="button" onclick="changeQty(${id}, 1)"
                                class="w-7 h-7 rounded bg-green-900/60 hover:bg-green-800 text-amber-100 text-sm font-bold">+</button>
                        <button type="button" onclick="removeFromCart(${id})"
                                class="w-7 h-7 rounded bg-red-700/60 hover:bg-red-600 text-white text-sm font-bold">×</button>
                    </div>
                </div>
            `;

            hidden += `<input type="hidden" name="items[${i}][menu_item_id]" value="${id}">`;
            hidden += `<input type="hidden" name="items[${i}][quantity]" value="${item.qty}">`;
        });

        itemsEl.innerHTML = html;
        countEl.textContent = count;
        totalEl.textContent = subtotal.toFixed(2);
        hiddenEl.innerHTML = hidden;
        btn.disabled = false;
    }

    /* ============================================================
       Old Items (after validation fail)
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const oldItems = @json(old('items', []));
        oldItems.forEach(function (item) {
            const menuItem = menuItems.find(m => m.id == item.menu_item_id);
            if (menuItem) {
                cart[menuItem.id] = {
                    id: menuItem.id,
                    name: menuItem.name,
                    price: menuItem.price,
                    qty: parseInt(item.quantity) || 1
                };
            }
        });
        if (Object.keys(cart).length > 0) renderCart();
    });
</script>