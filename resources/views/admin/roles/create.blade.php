<x-layouts.admin title="Create Role">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl overflow-hidden">

            <div class="px-6 py-5 bg-gradient-to-r from-red-900/60 to-transparent
                        border-b-2 border-red-800/50">
                <h2 class="text-2xl font-black text-amber-100">Create Role</h2>
                <p class="text-amber-200/60 text-sm mt-1">Define a new role with permissions</p>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                {{-- Role Name --}}
                <div>
                    <label class="block text-sm font-bold text-amber-100 mb-2">Role Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. menu-manager"
                           class="w-full px-4 py-3 rounded-xl bg-black/40 border-2 border-red-800/40
                                  text-amber-100 placeholder-amber-200/30
                                  focus:outline-none focus:border-amber-400 transition">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Permissions --}}
                <div>
                    <label class="block text-sm font-bold text-amber-100 mb-3">Permissions</label>

                    <div class="space-y-4">
                        @foreach($permissions as $group => $groupPermissions)
                            <div class="rounded-xl bg-black/30 border border-red-800/30 overflow-hidden">
                                <div class="px-4 py-3 bg-gradient-to-r from-red-900/40 to-transparent
                                            border-b border-red-800/40">
                                    <h4 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
                                        {{ ucfirst($group) }}
                                    </h4>
                                </div>
                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($groupPermissions as $permission)
                                        <label class="flex items-center gap-3 p-3 rounded-lg
                                                      bg-gray-900/60 border border-red-800/20
                                                      hover:bg-red-900/20 transition cursor-pointer">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                                   class="w-5 h-5 rounded border-2 border-red-800/50
                                                          bg-black text-amber-500
                                                          focus:ring-2 focus:ring-amber-400">
                                            <span class="text-sm text-amber-100">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-4 border-t-2 border-red-800/30">
                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-800
                                   hover:from-red-500 hover:to-red-700
                                   text-amber-50 font-bold shadow-lg shadow-red-900/50
                                   transition-all hover:scale-105">
                        💾 Create Role
                    </button>
                    <a href="{{ route('admin.roles.index') }}"
                       class="px-6 py-3 rounded-xl bg-gray-700/50 hover:bg-gray-600/50
                              text-amber-100 font-bold transition-all border border-gray-600/50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-layouts.admin>