<x-layouts.admin title="Add Employee">

    <div class="max-w-3xl mx-auto">

        {{-- HERO --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center gap-3 mb-3">
                <div class="p-2.5 rounded-xl bg-amber-500/10 border border-amber-400/30">
                    <x-lucide-user-plus class="w-6 h-6 text-amber-300" />
                </div>
                <h1 class="text-3xl font-black text-transparent bg-clip-text
                           bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                    Add Employee
                </h1>
            </div>

            <p class="text-amber-200/60 text-sm">
                Create a new employee account — cashier, chef, delivery, or any position.
            </p>

            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 text-amber-300 hover:text-amber-100
                      text-xs font-bold mt-3 transition-colors">
                <x-lucide-arrow-left class="w-3.5 h-3.5" />
                Back to Employees
            </a>
        </div>

        {{-- FORM --}}
        @include('admin.users._form', [
            'action' => route('admin.users.store'),
            'method' => 'POST',
            'submitLabel' => 'Create Employee',
            'positions' => $positions,
            'roles' => $roles,
            'userRoles' => [],
        ])
    </div>

</x-layouts.admin>