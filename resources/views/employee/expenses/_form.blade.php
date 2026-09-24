@php
    $isEdit = isset($expense) && $expense->exists;
    $action = $action ?? route('employee.expenses.store');
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? ($isEdit ? 'Update Expense' : 'Create Expense');

    $today = now()->toDateString();
    $oneYearAgo = now()->subYear()->toDateString();
@endphp

<form action="{{ $action }}" method="POST"
    class="overflow-hidden rounded-2xl
             bg-gradient-to-br from-gray-900 via-gray-800 to-black
             border-2 border-red-800/30
             shadow-2xl shadow-red-900/20">

    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- HEADER                                                       --}}
    <div
        class="px-6 py-4
                bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                border-b-2 border-red-700/50 flex items-center gap-2">
        <x-lucide-file-text class="w-4 h-4 text-amber-400" />
        <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
            Expense Details
        </h3>
    </div>

    {{-- BODY                                                         --}}
    <div class="px-6 py-6 space-y-6">

        {{-- ─── Title ─── --}}
        <div>
            <label for="title"
                class="block text-xs font-bold text-amber-300/80
                                      uppercase tracking-widest mb-2">
                Title <span class="text-red-400">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $expense->title ?? '') }}"
                placeholder="e.g. Electricity bill, Salary, Vegetables..."
                class="w-full px-4 py-3 rounded-lg
                          bg-black/50 border-2 border-red-800/30
                          text-amber-100 placeholder-amber-200/30
                          focus:outline-none focus:border-amber-600/60
                          transition-colors" />

            @error('title')
                <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                    <x-lucide-alert-circle class="w-3.5 h-3.5" />
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ─── Amount + Date ─── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Amount --}}
            <div>
                <label for="amount"
                    class="block text-xs font-bold text-amber-300/80
               uppercase tracking-widest mb-2">
                    Amount <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <input type="number" name="amount" id="amount" step="0.01" min="1"
                        value="{{ old('amount', $expense->amount ?? '') }}" placeholder="1.00" required
                        class="w-full px-4 py-3 pr-20 rounded-lg
                   bg-black/50 border-2 border-red-800/30
                   text-amber-100 placeholder-amber-200/30
                   focus:outline-none focus:border-amber-600/60
                   transition-colors" />
                    <span
                        class="absolute inset-y-0 right-4 flex items-center
                   text-amber-300/70 text-xs font-bold tracking-wider pointer-events-none">
                        {{ config('restaurant.currency', 'SYP') }}
                    </span>
                </div>

                @error('amount')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Date --}}
            <div>
                <label for="date"
                    class="block text-xs font-bold text-amber-300/80
               uppercase tracking-widest mb-2">
                    Date <span class="text-red-400">*</span>
                </label>
                <input type="date" name="date" id="date"
                    value="{{ old('date', isset($expense) && $expense->date ? $expense->date->format('Y-m-d') : $today) }}"
                    min="{{ $oneYearAgo }}" max="{{ $today }}" required
                    class="w-full px-4 py-3 rounded-lg
               bg-black/50 border-2 border-red-800/30
               text-amber-100
               [color-scheme:dark]
               focus:outline-none focus:border-amber-600/60
               transition-colors" />

                @error('date')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- ─── Hint ─── --}}
        <div
            class="flex items-start gap-2 p-4 rounded-lg
                    bg-amber-500/5 border border-amber-500/20">
            <x-lucide-info class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5" />
            <p class="text-xs text-amber-200/70 leading-relaxed">
                All fields marked with <span class="text-red-400 font-bold">*</span> are required.
                The expense will be recorded under your account.
            </p>
        </div>
    </div>

    {{-- FOOTER                                                       --}}
    <div
        class="px-6 py-4
                bg-gradient-to-r from-transparent to-red-900/20
                border-t-2 border-red-800/40
                flex flex-col md:flex-row items-center justify-end gap-3">

        <a href="{{ route('employee.expenses.index') }}"
            class="w-full md:w-auto text-center px-6 py-2.5 rounded-lg
                  bg-black/50 border-2 border-red-800/30
                  text-amber-200 font-bold
                  hover:border-amber-600/60 hover:text-amber-100
                  transition-all">
            Cancel
        </a>

        <button type="submit"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2
                       px-8 py-2.5 rounded-lg
                       bg-gradient-to-r from-amber-600 to-red-700
                       hover:from-amber-500 hover:to-red-600
                       text-white font-bold
                       shadow-lg shadow-red-900/40
                       transition-all">
            <x-lucide-save class="w-4 h-4" />
            {{ $submitLabel }}
        </button>
    </div>
</form>
