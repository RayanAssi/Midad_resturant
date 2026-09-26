<x-layouts.admin title="Employee Details">

    {{-- HERO --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-2 text-amber-300 hover:text-amber-100
                  text-sm font-bold mb-3 transition-colors">
            <x-lucide-arrow-left class="w-4 h-4" />
            Back to Employees
        </a>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="text-xs px-3 py-1 rounded-full
                                 bg-amber-500/15 text-amber-300
                                 border border-amber-400/40 font-bold tracking-wider">
                        #{{ $user->id }}
                    </span>

                    <span class="text-xs px-3 py-1 rounded-full
                                 bg-orange-500/15 text-orange-300
                                 border border-orange-400/40 font-bold tracking-wider">
                        {{ $user->role }}
                    </span>
                </div>

                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    {{ $user->name }}
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    {{ $user->position }} — Employee details.
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg
                          bg-gradient-to-r from-amber-600 to-orange-700
                          hover:from-amber-500 hover:to-orange-600
                          text-white font-bold
                          shadow-lg shadow-orange-900/40 transition-all">
                    <x-lucide-pencil class="w-4 h-4" />
                    Edit
                </a>

                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this employee? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg
                                   bg-gradient-to-r from-red-700 to-red-900
                                   hover:from-red-600 hover:to-red-800
                                   text-white font-bold
                                   shadow-lg shadow-red-900/40 transition-all">
                        <x-lucide-trash-2 class="w-4 h-4" />
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- DETAILS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        {{-- Email --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Email
                </span>
                <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-mail class="w-3.5 h-3.5 text-amber-300" />
                </div>
            </div>

            <div class="text-lg font-black text-amber-50 truncate">
                {{ $user->email }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                @if ($user->email_verified_at)
                    Verified {{ $user->email_verified_at->diffForHumans() }}
                @else
                    Not verified
                @endif
            </div>
        </div>

        {{-- Phone --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Phone
                </span>
                <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-phone class="w-3.5 h-3.5 text-amber-300" />
                </div>
            </div>

            <div class="text-lg font-black text-amber-50">
                {{ $user->phone }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                primary contact
            </div>
        </div>

        {{-- Position --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Position
                </span>
                <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                    <x-lucide-briefcase class="w-3.5 h-3.5 text-orange-300" />
                </div>
            </div>

            <div class="text-lg font-black text-amber-50">
                {{ $user->position }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                job title
            </div>
        </div>

        {{-- Joined --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Joined
                </span>
                <div class="p-1.5 rounded-lg bg-red-500/10 border border-red-400/30">
                    <x-lucide-calendar class="w-3.5 h-3.5 text-red-300" />
                </div>
            </div>

            <div class="text-lg font-black text-amber-50">
                {{ $user->created_at->format('Y-m-d') }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                {{ $user->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    {{-- ✅ ROLES — عرض كامل --}}
    <div class="relative overflow-hidden rounded-2xl
                bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-amber-800/30
                shadow-2xl shadow-amber-900/20
                p-6">
        <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full
                    bg-amber-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                        <x-lucide-shield-check class="w-4 h-4 text-amber-300" />
                    </div>
                    <span class="text-xs font-bold text-amber-300/80 uppercase tracking-widest">
                        Roles & Permissions
                    </span>
                </div>

                @if ($user->roles->count())
                    <span class="text-[10px] px-2.5 py-1 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30 font-bold">
                        {{ $user->roles->count() }} {{ Str::plural('role', $user->roles->count()) }}
                    </span>
                @endif
            </div>

            {{-- Roles --}}
            @if ($user->roles->count())
                <div class="flex flex-wrap gap-2">
                    @foreach ($user->roles as $role)
                        <span class="inline-flex items-center gap-2
                                     text-sm px-4 py-2 rounded-xl
                                     bg-gradient-to-r from-amber-600/20 to-orange-600/20
                                     text-amber-200 border border-amber-500/40
                                     font-bold tracking-wider">
                            <x-lucide-shield class="w-4 h-4" />
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
            @else
                <div class="flex items-center gap-2 text-red-300/70 py-2">
                    <x-lucide-shield-off class="w-5 h-5" />
                    <span class="text-sm italic">No roles assigned to this employee</span>
                </div>
            @endif

            {{-- Direct Permissions --}}
            @if ($user->getDirectPermissions()->count())
                <div class="mt-5 pt-5 border-t border-amber-700/30">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-bold text-orange-300/80 uppercase tracking-widest">
                            Direct Permissions
                        </span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full
                                     bg-orange-500/15 text-orange-200 border border-orange-400/30 font-bold">
                            {{ $user->getDirectPermissions()->count() }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($user->getDirectPermissions() as $perm)
                            <span class="text-xs px-3 py-1 rounded-full
                                         bg-orange-600/20 text-orange-200 border border-orange-500/40
                                         font-semibold">
                                {{ $perm->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>