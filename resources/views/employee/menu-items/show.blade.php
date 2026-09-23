<x-layouts.employee :title="$item->name">

    <a href="{{ route('employee.menu-items.index') }}"
       class="inline-flex items-center gap-2 text-amber-300/70
              hover:text-amber-200 mb-6 transition-colors">
        ← Back to list
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Card --}}
        <div class="lg:col-span-1">
            <x-menu-item-card :item="$item" route-prefix="employee" />
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- بدل x-card --}}
            <div class="rounded-2xl overflow-hidden
                        bg-gradient-to-br from-gray-900 via-gray-800 to-black
                        border-2 border-red-800/40 shadow-2xl shadow-red-900/20">

                <div class="px-6 py-4 bg-gradient-to-r from-red-900/40 to-transparent
                            border-b-2 border-red-800/40">
                    <h3 class="text-lg font-black text-amber-100">Item Details</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-black/40 border border-red-800/30">
                            <p class="text-xs text-amber-200/60 mb-1">Name</p>
                            <p class="text-amber-100 font-bold">{{ $item->name }}</p>
                        </div>

                        <div class="p-4 rounded-xl bg-black/40 border border-red-800/30">
                            <p class="text-xs text-amber-200/60 mb-1">Category</p>
                            <p class="text-amber-100 font-bold">{{ $item->category_label }}</p>
                        </div>

                        <div class="p-4 rounded-xl bg-black/40 border border-red-800/30">
                            <p class="text-xs text-amber-200/60 mb-1">Price</p>
                            <p class="text-amber-400 font-black text-lg">
                                {{ number_format($item->price, 2) }} SYP
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-black/40 border border-red-800/30">
                            <p class="text-xs text-amber-200/60 mb-1">Created</p>
                            <p class="text-amber-100 font-bold">
                                {{ $item->created_at->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <x-button href="{{ route('employee.menu-items.edit', $item->id) }}" variant="primary">
                    Edit
                </x-button>
                <x-button href="{{ route('employee.menu-items.index') }}" variant="secondary">
                    Back
                </x-button>
            </div>

        </div>
    </div>

</x-layouts.employee>