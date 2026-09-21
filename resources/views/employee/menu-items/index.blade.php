<x-layouts.app title="Cashier — Menu">

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-6">

        {{-- Left: Menu --}}
        <div>
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-black text-transparent bg-clip-text 
                               bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                        Menu
                    </h1>
                    <p class="text-amber-200/60 text-sm mt-1">
                        Select items to add to the order
                    </p>
                </div>

                <form method="GET" class="flex gap-2">
                    <select name="category" onchange="this.form.submit()"
                            class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                                   text-amber-100 focus:outline-none focus:border-red-600/60">
                        <option value="">All Categories</option>
                        @foreach(\App\Models\MenuItem::categories() as $cat)
                            <option value="{{ $cat }}" @selected(request('category') === $cat)>
                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($items->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($items as $item)
                        <x-menu-item-card :item="$item" :orderable="true" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 rounded-2xl bg-black/40 border-2 border-red-900/30">
                    <p class="text-amber-200/60">No menu items available.</p>
                </div>
            @endif
        </div>

        {{-- Right: Cart --}}
        <x-cart />
    </div>

</x-layouts.app>