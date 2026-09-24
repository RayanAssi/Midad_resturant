<x-layouts.employee title="Expense Details">

    {{-- HERO                                                         --}}
    <div class="mb-6">
        <a href="{{ route('employee.expenses.index') }}"
           class="inline-flex items-center gap-2 text-amber-300 hover:text-amber-100
                  text-sm font-bold mb-3 transition-colors">
            <x-lucide-arrow-left class="w-4 h-4" />
            Back to Expenses
        </a>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="text-xs px-3 py-1 rounded-full
                                 bg-amber-500/15 text-amber-300
                                 border border-amber-400/40 font-bold tracking-wider">
                        #{{ $expense->id }}
                    </span>

                    @if ($expense->user_id === auth()->id())
                        <span class="text-xs px-3 py-1 rounded-full
                                     bg-orange-500/15 text-orange-300
                                     border border-orange-400/40 font-bold tracking-wider">
                            mine
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    {{ $expense->title }}
                </h1>
                <p class="text-amber-200/60 text-sm mt-1">
                    Expense details and metadata.
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2">

                @if ($expense->user_id === auth()->id())
                    <a href="{{ route('employee.expenses.edit', $expense) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg
                              bg-gradient-to-r from-amber-600 to-orange-700
                              hover:from-amber-500 hover:to-orange-600
                              text-white font-bold
                              shadow-lg shadow-orange-900/40 transition-all">
                        <x-lucide-pencil class="w-4 h-4" />
                        Edit
                    </a>

                    <form action="{{ route('employee.expenses.destroy', $expense) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this expense? This cannot be undone.')">
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
                @endif
            </div>
        </div>
    </div>

    {{-- AMOUNT HERO                                                  --}}
    <div class="relative overflow-hidden rounded-2xl mb-6
                bg-gradient-to-br from-amber-950/40 via-gray-900 to-black
                border-2 border-amber-600/40
                shadow-2xl shadow-amber-900/30
                p-8">
        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full
                    bg-amber-400/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-48 h-48 rounded-full
                    bg-red-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <x-lucide-wallet class="w-5 h-5 text-amber-400" />
                <span class="text-xs font-bold text-amber-300 uppercase tracking-widest">
                    Amount
                </span>
            </div>

            <div class="text-5xl md:text-6xl font-black text-transparent bg-clip-text
                        bg-gradient-to-r from-amber-300 via-orange-400 to-red-500 leading-tight">
                {{ number_format($expense->amount, 2) }}
            </div>

            <div class="text-amber-200/60 text-sm mt-2 font-bold tracking-wider">
                {{ config('restaurant.currency', 'SYP') }}
            </div>
        </div>
    </div>

    {{-- DETAILS GRID                                                 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        {{-- Date --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Date
                </span>
                <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-calendar class="w-3.5 h-3.5 text-amber-300" />
                </div>
            </div>

            <div class="text-xl font-black text-amber-50">
                {{ $expense->date->format('Y-m-d') }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                {{ $expense->date->translatedFormat('l, F j, Y') }}
            </div>
        </div>

        {{-- Added by --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Added By
                </span>
                <div class="p-1.5 rounded-lg bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-user class="w-3.5 h-3.5 text-amber-300" />
                </div>
            </div>

            <div class="text-xl font-black text-amber-50 truncate">
                {{ $expense->user?->name ?? '—' }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1 truncate">
                {{ $expense->user?->email ?? '' }}
            </div>
        </div>

        {{-- Created at --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Created At
                </span>
                <div class="p-1.5 rounded-lg bg-orange-500/10 border border-orange-400/30">
                    <x-lucide-clock class="w-3.5 h-3.5 text-orange-300" />
                </div>
            </div>

            <div class="text-xl font-black text-amber-50">
                {{ $expense->created_at->format('Y-m-d') }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                {{ $expense->created_at->format('H:i') }}
            </div>
        </div>

        {{-- Last updated --}}
        <div class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-br from-gray-900 via-gray-800 to-black
                    border-2 border-red-800/30
                    shadow-2xl shadow-red-900/20
                    p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-amber-300/80 uppercase tracking-widest">
                    Last Updated
                </span>
                <div class="p-1.5 rounded-lg bg-red-500/10 border border-red-400/30">
                    <x-lucide-refresh-cw class="w-3.5 h-3.5 text-red-300" />
                </div>
            </div>

            <div class="text-xl font-black text-amber-50">
                {{ $expense->updated_at->diffForHumans() }}
            </div>
            <div class="text-amber-200/50 text-xs mt-1">
                {{ $expense->updated_at->format('Y-m-d H:i') }}
            </div>
        </div>
    </div>

    {{-- TITLE CARD                                                   --}}
    <div class="overflow-hidden rounded-2xl
                bg-gradient-to-br from-gray-900 via-gray-800 to-black
                border-2 border-red-800/30
                shadow-2xl shadow-red-900/20">

        <div class="px-6 py-4
                    bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                    border-b-2 border-red-700/50 flex items-center gap-2">
            <x-lucide-file-text class="w-4 h-4 text-amber-400" />
            <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
                Title
            </h3>
        </div>

        <div class="px-6 py-5">
            <p class="text-lg text-amber-50 leading-relaxed">
                {{ $expense->title }}
            </p>
        </div>
    </div>

</x-layouts.employee>