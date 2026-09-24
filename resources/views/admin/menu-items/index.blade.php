<x-layouts.admin title="Menu Items">

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
                <x-lucide-plus class="w-5 h-5" />
                New Item
            </a>
        </div>
    </div>

    @if($items->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($items as $item)
                <x-menu-item-card :item="$item"
                                  :editable="true"
                                  :deletable="true"
                                  route-prefix="admin"  />
            @endforeach
        </div>

        <x-pagination :paginator="$items" />
    @else
        <div class="text-center py-20 rounded-2xl bg-black/40 border-2 border-red-900/30">
            <p class="text-amber-200/60">No menu items found.</p>
        </div>
    @endif

    {{-- ============ Delete Modal ============ --}}
    <div id="delete-modal"
         class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4
                bg-black/70 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl overflow-hidden
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/50 shadow-2xl shadow-red-900/50">

            {{-- Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-red-900/60 to-transparent
                        border-b-2 border-red-800/40">
                <h3 class="text-xl font-black text-amber-100">
                    Confirm Delete
                </h3>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl
                                bg-red-500/20 border-2 border-red-500/40
                                flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-amber-100 font-medium mb-2">
                            Are you sure you want to delete this item?
                        </p>
                        <p id="delete-item-name"
                           class="text-red-300 font-black text-lg">
                            Item Name
                        </p>
                        <p class="text-amber-200/60 text-sm mt-3">
                            This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gradient-to-r from-transparent to-red-900/30
                        border-t-2 border-red-800/40
                        flex items-center justify-end gap-3">

                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-5 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                               text-amber-100 font-bold
                               hover:border-red-600/60 transition-all">
                    Cancel
                </button>

                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-5 py-2 rounded-lg
                                   bg-gradient-to-r from-red-600 to-red-800
                                   hover:from-red-500 hover:to-red-700
                                   text-amber-50 font-black
                                   shadow-lg shadow-red-900/50 transition-all">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id, name) {
            const modal = document.getElementById('delete-modal');
            const nameEl = document.getElementById('delete-item-name');
            const form = document.getElementById('delete-form');

            nameEl.textContent = name;
            form.action = '{{ url("admin/menu-items") }}/' + id;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Escape يغلق
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });

        // الضغط برا المودال يغلق
        document.getElementById('delete-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>

</x-layouts.admin>