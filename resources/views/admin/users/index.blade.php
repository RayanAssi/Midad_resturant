<x-layouts.admin title="Employees">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                Employees
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Manage your restaurant team — add, edit, and remove employees.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl
                  bg-gradient-to-r from-amber-600 to-red-700
                  hover:from-amber-500 hover:to-red-600
                  text-white font-bold
                  shadow-lg shadow-red-900/40 transition-all">
            <x-lucide-user-plus class="w-4 h-4" />
            Add Employee
        </a>
    </div>

    {{-- STATS — 3 بطاقات --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        {{-- Total Employees --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-amber-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Total Employees
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                        <x-lucide-users class="w-3.5 h-3.5 text-amber-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($total, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        all time
                    </span>
                </div>
            </div>
        </div>

        {{-- Added Today --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-orange-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Added Today
                    </span>
                    <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                        <x-lucide-calendar class="w-3.5 h-3.5 text-orange-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($todayCount, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-orange-500/15 text-orange-200 border border-orange-400/30">
                        today
                    </span>
                </div>
            </div>
        </div>

        {{-- Current Page --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-red-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Showing
                    </span>
                    <div class="p-1.5 rounded-lg bg-red-500/10 border border-red-400/30">
                        <x-lucide-list class="w-3.5 h-3.5 text-red-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ $users->count() }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-red-500/15 text-red-200 border border-red-400/30">
                        this page
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    {{-- FILTER --}}
<form method="GET"
      class="mb-6 overflow-hidden rounded-2xl
             bg-gradient-to-br from-gray-900 via-gray-800 to-black
             border-2 border-red-800/30
             shadow-2xl shadow-red-900/20">

    {{-- Header --}}
    <div class="px-6 py-4
                bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                border-b-2 border-red-700/50 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <x-lucide-search class="w-4 h-4 text-amber-400" />
            <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
                Filter & Search
            </h3>
        </div>

        @if (request('search') || request('phone') || request('position'))
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-1.5 text-xs text-amber-300
                      hover:text-amber-100 font-bold
                      transition-colors">
                <x-lucide-x class="w-3.5 h-3.5" />
                Clear all
            </a>
        @endif
    </div>

    {{-- Body --}}
    <div class="px-6 py-5 flex flex-wrap items-end gap-6">

        {{-- Search --}}
        <div class="flex items-center gap-2">
            <label for="search"
                   class="flex items-center gap-1.5 text-[10px] font-bold
                          text-amber-300/80 uppercase tracking-widest
                          whitespace-nowrap">
                Search
            </label>
            <input type="text" name="search" id="search"
                   value="{{ request('search') }}"
                   placeholder="Name or Email..."
                   class="w-48 px-3 py-2 rounded-lg bg-black/50
                          border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-amber-600/60
                          transition-colors" />
        </div>

        {{-- Phone --}}
        <div class="flex items-center gap-2">
            <label for="phone"
                   class="flex items-center gap-1.5 text-[10px] font-bold
                          text-amber-300/80 uppercase tracking-widest
                          whitespace-nowrap">
                Phone
            </label>
            <input type="text" name="phone" id="phone"
                   value="{{ request('phone') }}"
                   placeholder="0991234567"
                   class="w-36 px-3 py-2 rounded-lg bg-black/50
                          border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-amber-600/60
                          transition-colors" />
        </div>

        {{-- Position --}}
        <div class="flex items-center gap-2">
            <label for="position"
                   class="flex items-center gap-1.5 text-[10px] font-bold
                          text-amber-300/80 uppercase tracking-widest
                          whitespace-nowrap">
                Position
            </label>
            <input type="text" name="position" id="position"
                   value="{{ request('position') }}"
                   placeholder="Cashier, Chef..."
                   class="w-40 px-3 py-2 rounded-lg bg-black/50
                          border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-amber-600/60
                          transition-colors" />
        </div>

        {{-- Apply --}}
        <button type="submit"
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-lg                       
                           bg-gradient-to-r from-red-600 to-red-800
                           hover:from-red-500 hover:to-red-700
                           text-amber-50 font-bold
                           shadow-lg shadow-red-900/50 transition-all"
                       ">
                Filter
        </button>
    </div>
</form>

    {{-- TABLE --}}
    @php
        $headers = ['#', 'Name', 'Email', 'Phone', 'Position', 'Joined', 'Actions'];

        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.users.show', $user) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>

                <a href="{{ route('admin.users.edit', $user) }}"
                   title="Edit"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-pencil class="w-4 h-4" />
                </a>

                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this employee?')"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            title="Delete"
                            class="p-2 rounded-lg border border-red-400/40 bg-red-500/10
                                   text-red-300 hover:bg-red-500/20 hover:border-red-400/70
                                   transition-all">
                        <x-lucide-trash-2 class="w-4 h-4" />
                    </button>
                </form>
            </div>
        BLADE;

        $rows = $users
            ->map(function ($user) use ($actionsTemplate) {
                $actions = \Illuminate\Support\Facades\Blade::render($actionsTemplate, ['user' => $user]);

                return [
                    '<span class="text-amber-200/50">#' . $user->id . '</span>',
                    '<span class="font-bold text-amber-100">' . e($user->name) . '</span>',
                    '<span class="text-amber-200/80">' . e($user->email) . '</span>',
                    '<span class="text-amber-200/80">' . e($user->phone) . '</span>',
                    '<span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">'
                        . e($user->position) .
                    '</span>',
                    '<span class="text-amber-200/60">' . $user->created_at->format('Y-m-d') . '</span>',
                    $actions,
                ];
            })
            ->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="No employees found">
        <x-slot:footer>
            <x-pagination :paginator="$users" />
        </x-slot:footer>
    </x-table>

</x-layouts.admin>