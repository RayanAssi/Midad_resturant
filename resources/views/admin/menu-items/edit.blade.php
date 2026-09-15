<x-layouts.admin title="Edit Menu Item">

    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.menu-items.index') }}"
           class="inline-flex items-center gap-2 text-amber-300/70 
                  hover:text-amber-200 mb-6 transition-colors">
            ← Back to list
        </a>

        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl shadow-red-900/20 overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-red-900/40 to-transparent
                        border-b-2 border-red-800/40">
                <h2 class="text-2xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 to-orange-400">
                    Edit: {{ $item->name }}
                </h2>
            </div>

            <form action="{{ route('admin.menu-items.update', $item) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-6 space-y-5">
                @csrf
                @method('PUT')

                @include('admin.menu-items._form')

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('admin.menu-items.index') }}"
                       class="px-5 py-2 rounded-lg bg-black/40 border-2 border-red-800/40
                              text-amber-100 hover:border-red-600/60 transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 rounded-lg
                                   bg-gradient-to-r from-red-600 to-red-800
                                   hover:from-red-500 hover:to-red-700
                                   text-amber-50 font-bold
                                   shadow-lg shadow-red-900/50 transition-all">
                        Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.>