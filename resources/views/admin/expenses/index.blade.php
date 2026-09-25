<x-layouts.admin title="Expenses">

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- HEADER                                                       --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                Expenses
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Track daily expenses, revenue and net profit.
            </p>
        </div>

        <a href="{{ route('admin.expenses.create') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl
                  bg-gradient-to-r from-amber-600 to-red-700
                  hover:from-amber-500 hover:to-red-600
                  text-white font-bold
                  shadow-lg shadow-red-900/40 transition-all">
            <x-lucide-plus class="w-4 h-4" />
            Add Expense
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- ROW 1 — TODAY (4 بطاقات)                                      --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

        {{-- Today Expenses --}}
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
                        Today Expenses
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                        <x-lucide-trending-down class="w-3.5 h-3.5 text-amber-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($todayExpenses, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        {{ $todayCount }} {{ \Illuminate\Support\Str::plural('exp', $todayCount) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Today Revenue --}}
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
                        Today Revenue
                    </span>
                    <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                        <x-lucide-trending-up class="w-3.5 h-3.5 text-orange-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($todayRevenue, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-orange-500/15 text-orange-200 border border-orange-400/30">
                        from invoices
                    </span>
                </div>
            </div>
        </div>

        {{-- Today Net Profit --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-amber-950/40 via-gray-900 to-black
                    border-2 border-amber-600/40
                    shadow-2xl shadow-amber-900/30
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-amber-400/20 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300 uppercase tracking-widest">
                        Today Net Profit
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-500/20 border border-amber-400/50">
                        <x-lucide-wallet class="w-3.5 h-3.5 text-amber-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-transparent bg-clip-text
                            bg-gradient-to-r from-amber-300 to-red-400 leading-tight">
                    {{ number_format($todayNet, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        {{ $todayMargin >= 0 ? '+' : '' }}{{ number_format($todayMargin, 1) }}% margin
                    </span>
                </div>
            </div>
        </div>

        {{-- Average --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-amber-600/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Average
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-600/10 border border-amber-500/30">
                        <x-lucide-activity class="w-3.5 h-3.5 text-amber-400" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($average, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-600/15 text-amber-200 border border-amber-500/30">
                        per expense
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- ROW 2 — MONTH NET PROFIT + TOP EXPENSE                        --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6 items-stretch">

        {{-- Month Net Profit --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-amber-950/40 via-gray-900 to-black
                    border-2 border-amber-600/40
                    shadow-2xl shadow-amber-900/30
                    p-4">
            <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full
                        bg-amber-400/15 blur-3xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <x-lucide-wallet class="w-4 h-4 text-amber-400" />
                        <span class="text-xs font-bold text-amber-300 uppercase tracking-widest">
                            This Month · Net Profit
                        </span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        {{ $monthCount }} {{ \Illuminate\Support\Str::plural('exp', $monthCount) }}
                    </span>
                </div>

                <div class="text-2xl md:text-3xl font-black text-transparent bg-clip-text
                            bg-gradient-to-r from-amber-300 via-orange-400 to-red-500 leading-tight">
                    {{ number_format($monthNet, 0) }}
                </div>

                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        {{ $monthMargin >= 0 ? '+' : '' }}{{ number_format($monthMargin, 1) }}% margin
                    </span>
                </div>

                <div class="flex items-center justify-between gap-3 mt-3 pt-3 border-t border-amber-800/30 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="text-amber-200/60 uppercase tracking-widest">Rev</span>
                        <span class="font-bold text-amber-100">{{ number_format($monthRevenue, 0) }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-amber-200/60 uppercase tracking-widest">Exp</span>
                        <span class="font-bold text-amber-100">{{ number_format($monthExpenses, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Expense --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-4">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-amber-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center gap-2 mb-2">
                    <x-lucide-trophy class="w-4 h-4 text-amber-400" />
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-widest">
                        Top Expense
                    </span>
                </div>

                @if ($topExpense)
                    <div class="text-base font-bold text-amber-100 truncate"
                         title="{{ $topExpense->title }}">
                        {{ $topExpense->title }}
                    </div>

                    <div class="text-xl md:text-2xl font-black text-transparent bg-clip-text
                                bg-gradient-to-r from-amber-300 to-red-400 leading-tight mt-1">
                        {{ number_format($topExpense->amount, 0) }}
                    </div>

                    <div class="text-[11px] text-amber-200/60 mt-2 truncate">
                        {{ $topExpense->date->format('Y-m-d') }}
                        @if ($topExpense->user)
                            — by {{ $topExpense->user->name }}
                        @endif
                    </div>
                @else
                    <div class="text-amber-200/40 text-sm py-4">
                        No expense in this range.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- FILTER                                                       --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <form method="GET"
          class="mb-6 overflow-hidden rounded-2xl
                 bg-gradient-to-br from-gray-900 via-gray-800 to-black
                 border-2 border-red-800/30
                 shadow-2xl shadow-red-900/20">

        <div class="px-6 py-4
                    bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                    border-b-2 border-red-700/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
                Filter & Search
            </h3>

            @if (request('search') || request('from') || request('to') || request('user_id') || request('mine'))
                <a href="{{ route('admin.expenses.index') }}"
                   class="text-xs text-amber-300 hover:text-amber-100 font-bold
                          underline underline-offset-4 transition-colors">
                    Clear all
                </a>
            @endif
        </div>

        <div class="px-6 py-4 flex flex-wrap items-center gap-2">

            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search..."
                   class="w-70 px-3 py-2 rounded-lg bg-black/50
                          border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30 text-sm
                          focus:outline-none focus:border-amber-600/60 transition-colors" />

            <div class="flex items-center gap-2">
                <label class="text-xs text-amber-200/60 uppercase tracking-wider">From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="w-40 px-3 py-2 rounded-lg bg-black/50 border-2 border-red-800/30
                              text-amber-100 text-sm focus:outline-none focus:border-amber-600/60
                              [color-scheme:dark]" />
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs text-amber-200/60 uppercase tracking-wider">To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="w-40 px-3 py-2 rounded-lg bg-black/50 border-2 border-red-800/30
                              text-amber-100 text-sm focus:outline-none focus:border-amber-600/60
                              [color-scheme:dark]" />
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs text-amber-200/60 uppercase tracking-wider">User</label>
                <select name="user_id"
                        class="w-70 px-3 py-2 rounded-lg bg-black/50 border-2 border-red-800/30
                               text-amber-100 text-sm focus:outline-none focus:border-amber-600/60
                               [color-scheme:dark] max-w-[160px]">
                    <option value="">All users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->expenses_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <label class="w-35 inline-flex items-center gap-2 px-3 py-2 rounded-lg
                          bg-black/50 border-2 border-red-800/30
                          text-amber-100 text-sm cursor-pointer
                          hover:border-amber-600/60 transition-colors">
                <input type="checkbox" name="mine" value="1"
                       @checked(request('mine'))
                       class="accent-amber-500" />
                Mine only
            </label>

            <button type="submit"
                    class="px-4 py-2 rounded-lg
                           bg-gradient-to-r from-amber-600 to-red-700
                           bg-gradient-to-r from-red-600 to-red-800
                           hover:from-red-500 hover:to-red-700
                           text-amber-50 font-bold text-sm
                           shadow-lg shadow-red-900/50 transition-all">
                Apply
            </button>
        </div>
    </form>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- TABLE                                                        --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @php
        $headers = ['#', 'Title', 'Amount', 'Date', 'Added by', 'Actions'];

        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.expenses.show', $expense) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>

                <a href="{{ route('admin.expenses.edit', $expense) }}"
                   title="Edit"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-pencil class="w-4 h-4" />
                </a>

                <form action="{{ route('admin.expenses.destroy', $expense) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this expense?')"
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

        $rows = $expenses
            ->map(function ($expense) use ($actionsTemplate) {
                $addedBy = $expense->user
                    ? '<span class="text-amber-200/80">' . e($expense->user->name) . '</span>'
                    : '<span class="text-amber-200/30">—</span>';

                $title = '<span class="font-bold text-amber-100">' . e($expense->title) . '</span>';

                $actions = \Illuminate\Support\Facades\Blade::render($actionsTemplate, ['expense' => $expense]);

                return [
                    '<span class="text-amber-200/50">#' . $expense->id . '</span>',
                    $title,
                    '<span class="font-bold text-amber-100">' .
                        number_format($expense->amount, 2) . ' ' . config('restaurant.currency', 'SYP') .
                    '</span>',
                    '<span class="text-amber-200/60">' . $expense->date->format('Y-m-d') . '</span>',
                    $addedBy,
                    $actions,
                ];
            })
            ->toArray();
    @endphp

    <x-table :headers="$headers" :rows="$rows" emptyMessage="No expenses found">
        <x-slot:footer>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="text-amber-200/80 text-sm">
                    Filtered Total:
                    <span class="font-bold text-amber-100">
                        {{ number_format($total, 2) }} {{ config('restaurant.currency', 'SYP') }}
                    </span>
                    <span class="text-amber-200/50 ml-2">
                        ({{ $count }} {{ \Illuminate\Support\Str::plural('expense', $count) }})
                    </span>
                </div>
                <x-pagination :paginator="$expenses" />
            </div>
        </x-slot:footer>
    </x-table>

</x-layouts.admin>