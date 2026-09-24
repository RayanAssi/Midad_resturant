<x-layouts.employee title="Expenses">

    {{-- 1) HEADER                                                    --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-transparent bg-clip-text
                       bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                Expenses
            </h1>
            <p class="text-amber-200/60 text-sm mt-1">
                Track daily expenses — purchases, salaries, bills, maintenance.
            </p>
        </div>

        <a href="{{ route('employee.expenses.create') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl
                  bg-gradient-to-r from-amber-600 to-red-700
                  hover:from-amber-500 hover:to-red-600
                  text-white font-bold
                  shadow-lg shadow-red-900/40 transition-all">
            <x-lucide-plus class="w-4 h-4" />
            Add Expense
        </a>
    </div>

    {{-- 2) STATS — 5 بطاقات بنفس السطر                                --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

        {{-- ─── Today ─── --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">

            {{-- زخرفة خلفية --}}
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-amber-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Today
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                        <x-lucide-calendar class="w-3.5 h-3.5 text-amber-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($todayTotal, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-amber-500/15 text-amber-200 border border-amber-400/30">
                        {{ $todayCount }} {{ \Illuminate\Support\Str::plural('exp', $todayCount) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── This Week ─── --}}
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
                        This Week
                    </span>
                    <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                        <x-lucide-trending-up class="w-3.5 h-3.5 text-orange-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($weekTotal, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-orange-500/15 text-orange-200 border border-orange-400/30">
                        {{ $weekCount }} {{ \Illuminate\Support\Str::plural('exp', $weekCount) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── This Month ─── --}}
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
                        This Month
                    </span>
                    <div class="p-1.5 rounded-lg bg-red-500/10 border border-red-400/30">
                        <x-lucide-bar-chart-3 class="w-3.5 h-3.5 text-red-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($monthTotal, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-red-500/15 text-red-200 border border-red-400/30">
                        {{ $monthCount }} {{ \Illuminate\Support\Str::plural('exp', $monthCount) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── Average ─── --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full
                        bg-emerald-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                        Average
                    </span>
                    <div class="p-1.5 rounded-lg bg-emerald-500/10 border border-emerald-400/30">
                        <x-lucide-activity class="w-3.5 h-3.5 text-emerald-300" />
                    </div>
                </div>

                <div class="text-2xl font-black text-amber-50 leading-tight">
                    {{ number_format($average, 0) }}
                </div>

                <div class="flex items-center gap-1.5 mt-2">
                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                 bg-emerald-500/15 text-emerald-200 border border-emerald-400/30">
                        per expense
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── Top Expense ─── --}}
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
                        Top Expense
                    </span>
                    <div class="p-1.5 rounded-lg bg-amber-500/20 border border-amber-400/50">
                        <x-lucide-trophy class="w-3.5 h-3.5 text-amber-300" />
                    </div>
                </div>

                @if ($topExpense)
                    <div class="text-sm font-bold text-amber-100 truncate"
                         title="{{ $topExpense->title }}">
                        {{ $topExpense->title }}
                    </div>
                    <div class="text-xl font-black text-transparent bg-clip-text
                                bg-gradient-to-r from-amber-300 to-red-400 leading-tight mt-1">
                        {{ number_format($topExpense->amount, 0) }}
                    </div>
                    <div class="text-[10px] text-amber-200/60 mt-2 truncate">
                        {{ $topExpense->date->format('Y-m-d') }}
                        @if ($topExpense->user)
                            — {{ $topExpense->user->name }}
                        @endif
                    </div>
                @else
                    <div class="text-amber-200/40 text-xs py-3">
                        No expense yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 3) FILTER                                                     --}}
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

            @if (request('search') || request('from') || request('to') || request('mine'))
                <a href="{{ route('employee.expenses.index') }}"
                   class="text-xs text-amber-300 hover:text-amber-100 font-bold
                          underline underline-offset-4 transition-colors">
                    Clear all
                </a>
            @endif
        </div>

        <div class="px-6 py-5 flex flex-wrap items-center gap-3">

            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search title..."
                   class="flex-1 min-w-[200px] px-4 py-2.5 rounded-lg bg-black/50
                          border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30
                          focus:outline-none focus:border-amber-600/60 transition-colors" />

            <div class="flex items-center gap-2">
                <label class="text-xs text-amber-200/60 uppercase tracking-wider">From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="px-4 py-2.5 rounded-lg bg-black/50 border-2 border-red-800/30
                              text-amber-100 focus:outline-none focus:border-amber-600/60" />
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs text-amber-200/60 uppercase tracking-wider">To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="px-4 py-2.5 rounded-lg bg-black/50 border-2 border-red-800/30
                              text-amber-100 focus:outline-none focus:border-amber-600/60" />
            </div>

            <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg
                          bg-black/50 border-2 border-red-800/30
                          text-amber-100 text-sm cursor-pointer
                          hover:border-amber-600/60 transition-colors">
                <input type="checkbox" name="mine" value="1"
                       @checked(request('mine'))
                       class="accent-amber-500" />
                Mine only
            </label>

            <button type="submit"
                    class="px-6 py-2.5 rounded-lg
                           bg-gradient-to-r from-amber-600 to-red-700
                           hover:from-amber-500 hover:to-red-600
                           text-white font-bold
                           shadow-lg shadow-red-900/40 transition-all">
                Apply
            </button>
        </div>
    </form>

    {{-- 4) TABLE                                                      --}}
    @php
        $headers = ['#', 'Title', 'Amount', 'Date', 'Added by', 'Actions'];

        $actionsTemplate = <<<'BLADE'
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('employee.expenses.show', $expense) }}"
                   title="View"
                   class="p-2 rounded-lg border border-amber-400/40 bg-amber-500/10
                          text-amber-300 hover:bg-amber-500/20 hover:border-amber-400/70
                          transition-all">
                    <x-lucide-eye class="w-4 h-4" />
                </a>

                @if ($expense->user_id === auth()->id())
                    <a href="{{ route('employee.expenses.edit', $expense) }}"
                       title="Edit"
                       class="p-2 rounded-lg border border-blue-400/40 bg-blue-500/10
                              text-blue-300 hover:bg-blue-500/20 hover:border-blue-400/70
                              transition-all">
                        <x-lucide-pencil class="w-4 h-4" />
                    </a>

                    <form action="{{ route('employee.expenses.destroy', $expense) }}"
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
                @endif
            </div>
        BLADE;

        $rows = $expenses
            ->map(function ($expense) use ($actionsTemplate) {
                $addedBy = $expense->user
                    ? '<span class="text-amber-200/80">' . e($expense->user->name) . '</span>'
                    : '<span class="text-amber-200/30">—</span>';

                $isMine = $expense->user_id === auth()->id();

                $title = '<span class="font-bold text-amber-100">' . e($expense->title) . '</span>';

                if ($isMine) {
                    $title .= ' <span class="ml-2 text-[10px] px-2 py-0.5 rounded-full
                                          bg-amber-500/20 text-amber-300 border border-amber-400/40">
                                          mine
                                  </span>';
                }

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

</x-layouts.employee>