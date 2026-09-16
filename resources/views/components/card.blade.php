<div id="cart-panel"
     class="lg:sticky lg:top-24 h-fit rounded-2xl
            bg-gradient-to-br from-gray-900 via-gray-800 to-black
            border-2 border-red-800/40 shadow-2xl shadow-red-900/30
            overflow-hidden">

    <div class="px-5 py-4 bg-gradient-to-r from-red-900/60 to-transparent
                border-b-2 border-red-800/40 flex items-center justify-between">
        <h3 class="text-lg font-black text-amber-100">Current Order</h3>
        <span id="cart-count"
              class="px-3 py-1 rounded-full bg-red-700 text-amber-50
                     text-xs font-bold">0</span>
    </div>

    {{-- Cart Items --}}
    <div id="cart-items" class="max-h-[40vh] overflow-y-auto p-4 space-y-2">
        <p class="text-center text-amber-200/40 text-sm py-8">
            Cart is empty
        </p>
    </div>

    {{-- Total --}}
    <div class="px-5 py-4 border-t-2 border-red-800/40 
                bg-gradient-to-r from-transparent to-red-900/30">
        <div class="flex items-center justify-between mb-4">
            <span class="text-amber-200/70 text-sm font-bold">TOTAL</span>
            <span id="cart-total"
                  class="text-2xl font-black text-transparent bg-clip-text
                         bg-gradient-to-r from-amber-300 to-orange-400">
                0.00
            </span>
        </div>

        {{-- Order Form --}}
        <form id="order-form"
              action="{{ route('orders.store') }}"
              method="POST"
              class="space-y-3">
            @csrf

            <select name="type" required
                    class="w-full px-3 py-2 rounded-lg bg-black/40 
                           border-2 border-red-800/40 text-amber-100
                           text-sm focus:outline-none focus:border-red-600/60">
                <option value="dine_in">Dine In</option>
                <option value="take_out">Take Out</option>
                <option value="delivery">Delivery</option>
            </select>

            <input type="text" name="table_no" placeholder="Table No. (optional)"
                   class="w-full px-3 py-2 rounded-lg bg-black/40 
                          border-2 border-red-800/40 text-amber-100
                          placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-red-600/60" />

            <input type="text" name="address" placeholder="Address (optional)"
                   class="w-full px-3 py-2 rounded-lg bg-black/40 
                          border-2 border-red-800/40 text-amber-100
                          placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-red-600/60" />

            <textarea name="notes" rows="2" placeholder="Notes (optional)"
                      class="w-full px-3 py-2 rounded-lg bg-black/40 
                             border-2 border-red-800/40 text-amber-100
                             placeholder-amber-200/30 text-sm resize-none
                             focus:outline-none focus:border-red-600/60"></textarea>

            <div id="hidden-items"></div>

            <button type="submit" id="confirm-btn" disabled
                    class="w-full py-3 rounded-lg font-black text-sm tracking-wide
                           bg-gradient-to-r from-red-600 to-red-800
                           hover:from-red-500 hover:to-red-700
                           text-amber-50 shadow-lg shadow-red-900/50
                           transition-all disabled:opacity-40 
                           disabled:cursor-not-allowed disabled:hover:from-red-600">
                CONFIRM ORDER
            </button>
        </form>
    </div>
</div>

<script>
    const cart = {};

    function addToCart(id, name, price) {
        if (!cart[id]) {
            cart[id] = { id, name, price: parseFloat(price), qty: 1 };
        } else {
            cart[id].qty++;
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
        const itemsEl = document.getElementById('cart-items');
        const countEl = document.getElementById('cart-count');
        const totalEl = document.getElementById('cart-total');
        const hiddenEl = document.getElementById('hidden-items');
        const btn     = document.getElementById('confirm-btn');

        const ids = Object.keys(cart);

        if (ids.length === 0) {
            itemsEl.innerHTML = '<p class="text-center text-amber-200/40 text-sm py-8">Cart is empty</p>';
            countEl.textContent = '0';
            totalEl.textContent = '0.00';
            hiddenEl.innerHTML = '';
            btn.disabled = true;
            return;
        }

        let total = 0;
        let count = 0;
        let html = '';
        let hidden = '';

        ids.forEach((id, i) => {
            const item = cart[id];
            const sub = item.price * item.qty;
            total += sub;
            count += item.qty;

            html += `
                <div class="flex items-center justify-between gap-2 
                            p-3 rounded-lg bg-black/40 border border-red-800/30">
                    <div class="flex-1 min-w-0">
                        <p class="text-amber-100 text-sm font-bold truncate">${item.name}</p>
                        <p class="text-amber-300/70 text-xs">${item.price.toFixed(2)} × ${item.qty} = ${sub.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="changeQty(${id}, -1)"
                                class="w-6 h-6 rounded bg-red-900/50 hover:bg-red-800 text-amber-100 text-xs font-bold">−</button>
                        <button type="button" onclick="changeQty(${id}, 1)"
                                class="w-6 h-6 rounded bg-red-900/50 hover:bg-red-800 text-amber-100 text-xs font-bold">+</button>
                        <button type="button" onclick="removeFromCart(${id})"
                                class="w-6 h-6 rounded bg-red-700/60 hover:bg-red-600 text-white text-xs font-bold">×</button>
                    </div>
                </div>
            `;

            hidden += `<input type="hidden" name="items[${i}][id]" value="${id}">`;
            hidden += `<input type="hidden" name="items[${i}][quantity]" value="${item.qty}">`;
        });

        itemsEl.innerHTML = html;
        countEl.textContent = count;
        totalEl.textContent = total.toFixed(2);
        hiddenEl.innerHTML = hidden;
        btn.disabled = false;
    }
</script>