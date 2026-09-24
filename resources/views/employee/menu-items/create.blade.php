<x-layouts.employee title="New Menu Item">
    <div class="max-w-3xl mx-auto">

        <a href="{{ route('employee.menu-items.index') }}"
           class="inline-flex items-center gap-2 text-amber-300/70
                  hover:text-amber-200 mb-6 transition-colors">
            ← Back to list
        </a>

        {{-- بدل x-card --}}
        <div class="rounded-2xl overflow-hidden
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/40 shadow-2xl shadow-red-900/20">

            {{-- Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-red-900/40 to-transparent
                        border-b-2 border-red-800/40">
                <h3 class="text-lg font-black text-amber-100">Add New Item</h3>
                <p class="text-sm text-amber-200/60 mt-1">Fill in the details below</p>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <form action="{{ route('employee.menu-items.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf

                    <x-form.input name="name" label="Item Name" :value="old('name')" />

                    <x-form.input name="price" label="Price" type="number" step="0.01" :value="old('price')" />

                    <x-form.select
                        name="category"
                        label="Category"
                        :selected="old('category')"
                        :option="collect(\App\Models\MenuItem::categories())->mapWithKeys(fn($c) => [$c => ucfirst(str_replace('_', ' ', $c))])->toArray()"
                    />

                    <div>
                        <label class="block text-sm font-bold mb-2 text-amber-100">
                            Image <span class="text-red-400">*</span>
                        </label>
                        <input type="file" name="image" accept="image/*" required
                               class="w-full px-4 py-3 bg-gray-900 border-2 border-red-800/50
                                      rounded-xl text-amber-50 file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0 file:bg-amber-500/20
                                      file:text-amber-300 file:font-bold hover:file:bg-amber-500/30">
                        @error('image')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-4 border-t-2 border-red-900/30">
                        <x-button type="submit" variant="primary">Save</x-button>
                        <x-button href="{{ route('employee.menu-items.index') }}" variant="secondary">Cancel</x-button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.employee>