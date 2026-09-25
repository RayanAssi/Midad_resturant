@php
    $isEdit = isset($user) && $user->exists;
    $action = $action ?? route('admin.users.store');
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? ($isEdit ? 'Update Employee' : 'Create Employee');
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

    {{-- HEADER --}}
    <div class="px-6 py-4
                bg-gradient-to-r from-red-900/60 via-red-800/40 to-transparent
                border-b-2 border-red-700/50 flex items-center gap-2">
        <x-lucide-user class="w-4 h-4 text-amber-400" />
        <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
            Employee Details
        </h3>
    </div>

    {{-- BODY --}}
    <div class="px-6 py-6 space-y-6">

        {{-- Name + Email --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-bold text-amber-300/80
                                         uppercase tracking-widest mb-2">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $user->name ?? '') }}"
                       placeholder="e.g. Ahmed Ali"
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />

                @error('name')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-bold text-amber-300/80
                                          uppercase tracking-widest mb-2">
                    Email <span class="text-red-400">*</span>
                </label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', $user->email ?? '') }}"
                       placeholder="e.g. ahmed@midad.com"
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />

                @error('email')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Phone + Position --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-xs font-bold text-amber-300/80
                                          uppercase tracking-widest mb-2">
                    Phone <span class="text-red-400">*</span>
                </label>
                <input type="text" name="phone" id="phone"
                       value="{{ old('phone', $user->phone ?? '') }}"
                       placeholder="e.g. 0991234567"
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />

                @error('phone')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Position --}}
            <div>
                <label for="position" class="block text-xs font-bold text-amber-300/80
                                             uppercase tracking-widest mb-2">
                    Position <span class="text-red-400">*</span>
                </label>
                <input type="text" name="position" id="position"
                       value="{{ old('position', $user->position ?? '') }}"
                       placeholder="e.g. Cashier, Chef, Delivery..."
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />

                @error('position')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Password + Confirmation --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-bold text-amber-300/80
                                             uppercase tracking-widest mb-2">
                    Password
                    @if (!$isEdit)
                        <span class="text-red-400">*</span>
                    @else
                        <span class="text-amber-200/50 normal-case tracking-normal">
                            (leave blank to keep current)
                        </span>
                    @endif
                </label>
                <input type="password" name="password" id="password"
                       placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />

                @error('password')
                    <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                        <x-lucide-alert-circle class="w-3.5 h-3.5" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-amber-300/80
                                                          uppercase tracking-widest mb-2">
                    Confirm Password
                    @if (!$isEdit)
                        <span class="text-red-400">*</span>
                    @endif
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors" />
            </div>
        </div>

        {{-- Hint --}}
        <div class="flex items-start gap-2 p-4 rounded-lg
                    bg-amber-500/5 border border-amber-500/20">
            <x-lucide-info class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5" />
            <p class="text-xs text-amber-200/70 leading-relaxed">
                All fields marked with <span class="text-red-400 font-bold">*</span> are required.
                The role will be set to <span class="text-amber-300 font-bold">employee</span> automatically.
            </p>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="px-6 py-4
                bg-gradient-to-r from-transparent to-red-900/20
                border-t-2 border-red-800/40
                flex flex-col md:flex-row items-center justify-end gap-3">

        <a href="{{ route('admin.users.index') }}"
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