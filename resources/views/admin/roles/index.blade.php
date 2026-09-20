<x-layouts.admin title="Roles & Permissions">

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    Roles & Permissions
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    Manage roles and their permissions
                </p>
            </div>

            <a href="{{ route('admin.roles.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                      bg-gradient-to-r from-red-600 to-red-800
                      hover:from-red-500 hover:to-red-700
                      text-amber-50 font-bold shadow-lg shadow-red-900/50
                      transition-all hover:scale-105 active:scale-95">
                <span class="text-lg">+</span>
                New Role
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-red-800/30 p-5">
                <p class="text-xs text-amber-200/60 font-bold">Total Roles</p>
                <p class="text-3xl font-black text-amber-400 mt-2">{{ $stats['total_roles'] }}</p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-amber-500/30 p-5">
                <p class="text-xs text-amber-200/60 font-bold">Total Permissions</p>
                <p class="text-3xl font-black text-amber-400 mt-2">{{ $stats['total_permissions'] }}</p>
            </div>
            <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-black
                        border-2 border-green-500/30 p-5">
                <p class="text-xs text-amber-200/60 font-bold">Total Users</p>
                <p class="text-3xl font-black text-green-400 mt-2">{{ $stats['total_users'] }}</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30 shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-900/60 to-transparent border-b-2 border-red-700/50">
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">#</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Role Name</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Permissions</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Users</th>
                            <th class="px-6 py-4 text-sm font-bold text-amber-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-900/30">
                        @forelse($roles as $role)
                            <tr class="hover:bg-red-900/20 transition">
                                <td class="px-6 py-4 text-amber-400 font-black">#{{ $role->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-bold
                                                 bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                        {{ $role->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-amber-200/70 text-sm">
                                        {{ $role->permissions->count() }} permissions
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-amber-200/70 text-sm">
                                        {{ $role->users_count }} users
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.roles.show', $role->id) }}"
                                           class="px-3 py-1.5 rounded-lg bg-amber-500/20 hover:bg-amber-500/30
                                                  border border-amber-500/40 text-amber-300 text-sm
                                                  transition-all">
                                            View
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                           class="px-3 py-1.5 rounded-lg bg-blue-500/20 hover:bg-blue-500/30
                                                  border border-blue-500/40 text-blue-300 text-sm
                                                  transition-all">
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
                                                               border border-red-500/40 text-red-300 text-sm
                                                               transition-all">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
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

</x-layouts.admin>