@props(['user'])

<div class="profile-panel hidden" data-panel="roles">
    <div class="rounded-3xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-amber-500/30 shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 bg-gradient-to-r from-amber-900/40 via-amber-800/20 to-transparent
                    border-b-2 border-amber-700/40 flex items-center justify-between flex-wrap gap-3">
            <div>
                <h2 class="text-2xl font-black text-amber-100 flex items-center gap-2">
                    <span>🛡️</span>
                    Roles & Permissions
                </h2>
                <p class="text-amber-200/60 text-sm mt-1">
                    Manage roles and their permissions
                </p>
            </div>

            @can('roles.manage', 'web')
                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                          bg-gradient-to-r from-red-600 to-red-800
                          hover:from-red-500 hover:to-red-700
                          text-amber-50 font-bold shadow-lg shadow-red-900/50
                          transition-all hover:scale-105 active:scale-95 text-sm">
                    <span>+</span>
                    New Role
                </a>
            @endcan
        </div>

        {{-- Stats --}}
        <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-red-800/30 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🛡️</span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Total Roles</p>
                <p class="text-3xl font-black text-amber-400 mt-1">
                    {{ \Spatie\Permission\Models\Role::count() }}
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-amber-500/30 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🔑</span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Permissions</p>
                <p class="text-3xl font-black text-amber-400 mt-1">
                    {{ \Spatie\Permission\Models\Permission::count() }}
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-green-500/30 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">👥</span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Users</p>
                <p class="text-3xl font-black text-green-400 mt-1">
                    {{ \App\Models\User::count() }}
                </p>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-blue-500/30 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🎭</span>
                </div>
                <p class="text-xs text-amber-200/60 font-bold">Your Role</p>
                <p class="text-lg font-black text-blue-400 mt-1 truncate">
                    {{ $user->getRoleNames()->first() ?? 'No role' }}
                </p>
            </div>
        </div>

        {{-- Roles Table --}}
        @php
            $roles = \Spatie\Permission\Models\Role::withCount(['permissions', 'users'])->get();
        @endphp

        <div class="px-6 pb-6">
            <div class="rounded-2xl bg-black/30 border border-red-800/30 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-900/60 to-transparent
                                       border-b-2 border-red-700/50">
                                <th class="px-6 py-4 text-sm font-bold text-amber-100">#</th>
                                <th class="px-6 py-4 text-sm font-bold text-amber-100">Role</th>
                                <th class="px-6 py-4 text-sm font-bold text-amber-100 text-center">Permissions</th>
                                <th class="px-6 py-4 text-sm font-bold text-amber-100 text-center">Users</th>
                                <th class="px-6 py-4 text-sm font-bold text-amber-100 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-red-900/30">
                            @forelse($roles as $role)
                                <tr class="hover:bg-red-900/20 transition">
                                    <td class="px-6 py-4 text-amber-400 font-black">
                                        #{{ $role->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-bold
                                                     bg-amber-500/20 text-amber-300
                                                     border border-amber-500/40">
                                            {{ $role->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-amber-200/70 text-sm">
                                        {{ $role->permissions_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-amber-200/70 text-sm">
                                        {{ $role->users_count }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            @can('roles.manage', 'web')
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                   class="px-3 py-1.5 rounded-lg bg-blue-500/20 hover:bg-blue-500/30
                                                          border border-blue-500/40 text-blue-300
                                                          text-xs font-bold transition-all">
                                                    Edit
                                                </a>

                                                @if($role->name !== 'super-admin')
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Delete this role?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="px-3 py-1.5 rounded-lg bg-red-500/20 hover:bg-red-500/30
                                                                       border border-red-500/40 text-red-300
                                                                       text-xs font-bold transition-all">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-amber-200/60">
                                        No roles yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>