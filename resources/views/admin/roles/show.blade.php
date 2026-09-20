<x-layouts.admin title="Role: {{ $role->name }}">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 to-transparent
                        border-b-2 border-red-800/50 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-amber-100">Role: {{ $role->name }}</h2>
                    <p class="text-amber-200/60 text-sm mt-1">{{ $role->permissions->count() }} permissions</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                       class="px-4 py-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/30
                              border border-blue-500/40 text-blue-300 font-bold
                              transition-all">
                        Edit
                    </a>
                    <a href="{{ route('admin.roles.index') }}"
                       class="px-4 py-2 rounded-lg bg-gray-700/50 hover:bg-gray-600/50
                              border border-gray-600/50 text-amber-100 font-bold
                              transition-all">
                        Back
                    </a>
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-lg font-bold text-amber-100 mb-4">Permissions</h3>

                @if($role->permissions->isEmpty())
                    <p class="text-center text-amber-200/60 py-8">No permissions assigned</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($role->permissions as $permission)
                            <div class="px-4 py-3 rounded-lg bg-black/30 border border-amber-800/30
                                        flex items-center gap-3">
                                <span class="text-green-400 text-xl">✓</span>
                                <span class="text-amber-100 text-sm">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-layouts.admin>