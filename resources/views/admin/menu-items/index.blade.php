<x-layouts.app title="Menu Items">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text 
                       bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                Menu Items
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Manage your restaurant menu
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search..."
                       class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-red-600/60 transition-colors" />

                <select name="category"
                        class="px-4 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                               text-amber-100 focus:outline-none focus:border-red-600/60">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\MenuItem::categories() as $cat)
                        <option value="{{ $cat }}" @selected(request('category') === $cat)>
                            {{ ucfirst(str_replace('_', ' ', $cat)) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="px-5 py-2 rounded-lg
                               bg-gradient-to-r from-red-600 to-red-800
                               hover:from-red-500 hover:to-red-700
                               text-amber-50 font-bold
                               shadow-lg shadow-red-900/50 transition-all">
                    Filter
                </button>
            </form>

            <a href="{{ route('admin.menu-items.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-lg
                      bg-gradient-to-r from-amber-500 to-orange-600
                      hover:from-amber-400 hover:to-orange-500
                      text-black font-bold
                      shadow-lg shadow-orange-900/50 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Item
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 px-5 py-4 rounded-xl
                    bg-green-950/50 border-2 border-green-700/50
                    text-green-200 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($items->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($items as $item)
                <x-menu-item-card :item="$item"
                                  :editable="true"
                                  :deletable="true" />
            @endforeach
        </div>

        <x-pagination :paginator="$items" />
    @else
        <div class="text-center py-20 rounded-2xl bg-black/40 border-2 border-red-900/30">
            <p class="text-amber-200/60">No menu items found.</p>
        </div>
    @endif

</x-layouts.app>