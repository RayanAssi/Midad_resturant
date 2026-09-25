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

    {{-- STATS ROW --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        {{-- Orders Count --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Orders
                </span>
                <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-receipt class="w-3.5 h-3.5 text-amber-300" />
                </div>
            </div>

            <div class="text-2xl font-black text-transparent bg-clip-text
                        bg-gradient-to-r from-amber-300 to-red-400 leading-tight">
                {{ $user->orders()->count() }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                total orders
            </div>
        </div>

        {{-- Expenses Count --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Expenses
                </span>
                <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                    <x-lucide-wallet class="w-3.5 h-3.5 text-orange-300" />
                </div>
            </div>

            <div class="text-2xl font-black text-transparent bg-clip-text
                        bg-gradient-to-r from-amber-300 to-red-400 leading-tight">
                {{ $user->expenses()->count() }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                total expenses recorded
            </div>
        </div>
    </div>

</x-layouts.admin>