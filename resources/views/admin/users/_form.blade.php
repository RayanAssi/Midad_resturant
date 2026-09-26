@php
    $isEdit = isset($user) && $user->exists;
    $action = $action ?? route('admin.users.store');
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? ($isEdit ? 'Update Employee' : 'Create Employee');
    $positions = $positions ?? collect();
    $roles = $roles ?? collect();
    $userRoles = $userRoles ?? [];
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
    <div
        class="px-6 py-4
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
                <label for="name"
                    class="block text-xs font-bold text-amber-300/80
                                         uppercase tracking-widest mb-2">
                    Full Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
                    placeholder="e.g. Ahmed Ali"
                    class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors
                              @error('name') is-invalid @enderror" />
            </div>

            {{-- Email --}}
            <div>
                <label for="email"
                    class="block text-xs font-bold text-amber-300/80
                                          uppercase tracking-widest mb-2">
                    Email <span class="text-red-400">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                    placeholder="e.g. ahmed@midad.com"
                    class="w-full px-4 py-3 rounded-lg
                              bg-black/50 border-2 border-red-800/30
                              text-amber-100 placeholder-amber-200/30
                              focus:outline-none focus:border-amber-600/60
                              transition-colors
                              @error('email') is-invalid @enderror" />
            </div>
        </div>

        {{-- Phone + Position --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Phone --}}
            <div>
                <label for="phone"
                    class="block text-xs font-bold text-amber-300/80
                                        uppercase tracking-widest mb-2">
                    Phone <span class="text-red-400">*</span>
                </label>

                <div class="relative w-full">
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        placeholder="991 234 567"
                        class="w-full px-4 py-3 rounded-lg
                                  bg-black/50 border-2 border-red-800/30
                                  text-amber-100 placeholder-amber-200/30
                                  focus:outline-none focus:border-amber-600/60
                                  transition-colors
                                  @error('phone') is-invalid @enderror" />

                    <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code', '') }}" />
                </div>
            </div>

            {{-- Position (ComboBox) --}}
            <div>
                <label for="position"
                    class="block text-xs font-bold text-amber-300/80
                                             uppercase tracking-widest mb-2">
                    Position <span class="text-red-400">*</span>
                </label>

                <div class="relative">
                    <input type="text" name="position" id="position"
                        value="{{ old('position', $user->position ?? '') }}"
                        placeholder="e.g. Cashier, Chef, Delivery..." autocomplete="off"
                        class="w-full px-4 py-3 pr-12 rounded-lg
                                  bg-black/50 border-2 border-red-800/30
                                  text-amber-100 placeholder-amber-200/30
                                  focus:outline-none focus:border-amber-600/60
                                  transition-colors
                                  @error('position') is-invalid @enderror" />

                    <button type="button" id="position-toggle"
                        class="absolute inset-y-0 right-0 flex items-center px-3
                               text-amber-400 hover:text-amber-300
                               transition-colors focus:outline-none">
                        <x-lucide-chevron-down class="w-5 h-5" id="position-toggle-icon" />
                    </button>

                    <div id="position-dropdown"
                        class="hidden absolute z-50 mt-1 w-full
                               max-h-56 overflow-y-auto
                               bg-[#0a0a0a] border-2 border-red-800/40
                               rounded-lg shadow-2xl shadow-black/80
                               py-1">
                        @forelse ($positions as $pos)
                            <button type="button" data-value="{{ $pos }}"
                                class="position-option w-full text-left px-4 py-2.5
                                       text-sm text-amber-100
                                       hover:bg-red-900/50 hover:text-white
                                       transition-colors">
                                {{ $pos }}
                            </button>
                        @empty
                            <div class="px-4 py-2.5 text-sm text-amber-200/40 italic">
                                No previous positions — type a new one.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Password + Confirmation --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Password --}}
            <div>
                <label for="password"
                    class="block text-xs font-bold text-amber-300/80
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

                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="w-full px-4 py-3 pr-12 rounded-lg
                                  bg-black/50 border-2 border-red-800/30
                                  text-amber-100 placeholder-amber-200/30
                                  focus:outline-none focus:border-amber-600/60
                                  transition-colors
                                  @error('password') is-invalid @enderror" />

                    <button type="button" onclick="togglePassword('password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3
                               text-amber-400 hover:text-amber-300
                               transition-colors focus:outline-none">
                        <x-lucide-eye class="w-5 h-5" />
                    </button>
                </div>
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation"
                    class="block text-xs font-bold text-amber-300/80
                                                          uppercase tracking-widest mb-2">
                    Confirm Password
                    @if (!$isEdit)
                        <span class="text-red-400">*</span>
                    @endif
                </label>

                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 pr-12 rounded-lg
                                  bg-black/50 border-2 border-red-800/30
                                  text-amber-100 placeholder-amber-200/30
                                  focus:outline-none focus:border-amber-600/60
                                  transition-colors" />

                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3
                               text-amber-400 hover:text-amber-300
                               transition-colors focus:outline-none">
                        <x-lucide-eye class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- ROLES SECTION                                            --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="pt-6 border-t-2 border-red-800/30">
            <div class="flex items-center gap-2 mb-2">
                <x-lucide-shield class="w-4 h-4 text-amber-400" />
                <h3 class="text-sm font-bold text-amber-100 uppercase tracking-wider">
                    Roles & Permissions
                </h3>
            </div>

            <p class="text-xs text-amber-200/50 mb-4">
                Select the roles this employee should have. Permissions are inherited from the assigned roles.
            </p>

            @if ($roles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($roles as $role)
                        @php
                            $isChecked = in_array(
                                $role->name,
                                old('roles', $userRoles)
                            );
                        @endphp

                        <label
                            class="group flex items-start gap-3 p-4 rounded-xl
                                   bg-black/50 border-2 border-red-800/30
                                   hover:border-amber-500/60 hover:bg-amber-950/20
                                   transition-all cursor-pointer
                                   {{ $isChecked ? 'border-amber-500/60 bg-amber-950/20' : '' }}">

                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ $isChecked ? 'checked' : '' }}
                                class="mt-1 w-5 h-5 rounded border-2 border-amber-600/50
                                       bg-black text-amber-500
                                       focus:ring-2 focus:ring-amber-400
                                       cursor-pointer">

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-black text-amber-200 text-sm">
                                        {{ $role->name }}
                                    </span>
                                    <span
                                        class="text-[10px] px-1.5 py-0.5 rounded
                                               bg-amber-500/10 text-amber-300/70
                                               border border-amber-500/20
                                               font-mono">
                                        {{ $role->permissions->count() }} perms
                                    </span>
                                </div>

                                @if ($role->permissions->count() > 0)
                                    <p class="text-[11px] text-amber-200/50 leading-relaxed">
                                        {{ $role->permissions->take(3)->pluck('name')->join(', ') }}
                                        @if ($role->permissions->count() > 3)
                                            <span class="text-amber-300/40 font-bold">
                                                +{{ $role->permissions->count() - 3 }} more
                                            </span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-[11px] text-amber-200/30 italic">
                                        No permissions assigned
                                    </p>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('roles')
                    <p class="mt-3 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @error('roles.*')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            @else
                <div class="text-center py-6 rounded-xl bg-black/40 border-2 border-red-800/20">
                    <p class="text-amber-200/50 text-sm">No roles available</p>
                </div>
            @endif
        </div>

        {{-- Hint / Error Box --}}
        @if ($errors->any())
            <div class="flex items-start gap-2 p-4 rounded-lg
                        bg-red-500/10 border border-red-500/30">
                <x-lucide-alert-circle class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" />
                <div class="text-xs text-red-200/90 leading-relaxed space-y-1">
                    <p class="font-bold text-red-300">
                        Please fix the following errors:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="flex items-start gap-2 p-4 rounded-lg
                        bg-amber-500/5 border border-amber-500/20">
                <x-lucide-info class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5" />
                <p class="text-xs text-amber-200/70 leading-relaxed">
                    All fields marked with <span class="text-red-400 font-bold">*</span> are required.
                    The role will be set to <span class="text-amber-300 font-bold">employee</span> automatically.
                </p>
            </div>
        @endif
    </div>

    {{-- FOOTER --}}
    <div
        class="px-6 py-4
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

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- intl-tel-input — Dark Theme CSS + Position ComboBox          --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<style>
    /* ═══════════════════════════════════════════════════════
       🎨 intl-tel-input — Dark Theme (No White Gaps)
       ═══════════════════════════════════════════════════════ */
    .iti__country-selector {
        background-color: #0a0a0a !important;
        border: 2px solid rgba(127, 29, 29, 0.5) !important;
        border-radius: 12px !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8) !important;
        padding: 0 !important;
    }

    .iti__search-input-wrapper {
        background-color: #0a0a0a !important;
        padding: 8px !important;
        margin: 0 !important;
        border-bottom: 2px solid rgba(127, 29, 29, 0.3) !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .iti__search-icon {
        color: #fbbf24 !important;
        background-color: transparent !important;
        flex-shrink: 0 !important;
        padding-left: 4px !important;
    }

    .iti__search-clear {
        color: #fbbf24 !important;
        background-color: transparent !important;
    }

    .iti__search-input {
        background-color: #1a0a0a !important;
        border: 2px solid rgba(127, 29, 29, 0.4) !important;
        border-radius: 8px !important;
        color: #fef3c7 !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        flex: 1 !important;
        min-width: 0 !important;
        outline: none !important;
    }

    .iti__search-input::placeholder {
        color: rgba(253, 230, 138, 0.4) !important;
        padding-left: 12px !important;
    }

    .iti__search-input:focus {
        outline: none !important;
        border-color: #d97706 !important;
        background-color: #1a0a0a !important;
    }

    .iti__all-tytt {
        background-color: #0a0a0a !important;
        color: rgba(253, 230, 138, 0.6) !important;
        padding: 8px 14px !important;
        display: block !important;
        font-size: 12px !important;
        border-bottom: 1px solid rgba(127, 29, 29, 0.3) !important;
    }

    .iti__country-list {
        background-color: #0a0a0a !important;
        border: none !important;
        border-radius: 0 !important;
        max-height: 260px !important;
        overflow-y: auto !important;
        list-style: none !important;
        padding: 4px !important;
        margin: 0 !important;
    }

    .iti__country {
        padding: 10px 14px !important;
        color: #fde68a !important;
        background-color: #0a0a0a !important;
        cursor: pointer !important;
        transition: background-color 0.15s ease, color 0.15s ease;
        border-radius: 6px !important;
    }

    .iti__country:hover {
        background-color: rgba(127, 29, 29, 0.5) !important;
        color: #ffffff !important;
    }

    .iti__country.iti__highlight {
        background-color: rgba(217, 119, 6, 0.35) !important;
        color: #ffffff !important;
    }

    .iti__country-name {
        color: inherit !important;
    }

    .iti__dial-code {
        color: #fbbf24 !important;
        font-weight: 700 !important;
    }

    .iti__no-results {
        background-color: #0a0a0a !important;
        color: rgba(253, 230, 138, 0.6) !important;
        padding: 12px !important;
    }

    .iti__divider {
        border-bottom-color: rgba(127, 29, 29, 0.3) !important;
        background-color: #0a0a0a !important;
    }

    .iti__selected-flag {
        background-color: rgba(0, 0, 0, 0.6) !important;
        border-right: 2px solid rgba(127, 29, 29, 0.4) !important;
        padding: 0 12px !important;
        transition: background-color 0.15s ease;
    }

    .iti__selected-flag:hover,
    .iti__selected-flag:focus {
        background-color: rgba(127, 29, 29, 0.35) !important;
    }

    .iti__selected-dial-code {
        color: #fbbf24 !important;
        font-weight: 700 !important;
        margin-left: 6px !important;
    }

    .iti__arrow {
        border-top-color: #fbbf24 !important;
        margin-left: 8px !important;
    }

    .iti__arrow--up {
        border-bottom-color: #fbbf24 !important;
        border-top-color: transparent !important;
    }

    .iti__country-list::-webkit-scrollbar {
        width: 8px;
    }

    .iti__country-list::-webkit-scrollbar-track {
        background: #0a0a0a;
    }

    .iti__country-list::-webkit-scrollbar-thumb {
        background: rgba(127, 29, 29, 0.6);
        border-radius: 8px;
    }

    .iti__country-list::-webkit-scrollbar-thumb:hover {
        background: rgba(217, 119, 6, 0.7);
    }

    .iti {
        width: 100% !important;
        display: block !important;
    }

    .iti input[type="tel"] {
        width: 100% !important;
        padding-left: 110px !important;
    }

    .iti__country-list {
        width: 100% !important;
        min-width: 320px !important;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px #1a0a0a inset !important;
        -webkit-text-fill-color: #fef3c7 !important;
        transition: background-color 5000s ease-in-out 0s;
        caret-color: #fef3c7 !important;
    }

    .iti__search-input:-webkit-autofill,
    .iti__search-input:-webkit-autofill:hover,
    .iti__search-input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 30px #1a0a0a inset !important;
        -webkit-text-fill-color: #fef3c7 !important;
    }

    #position-dropdown::-webkit-scrollbar {
        width: 8px;
    }

    #position-dropdown::-webkit-scrollbar-track {
        background: #0a0a0a;
        border-radius: 8px;
    }

    #position-dropdown::-webkit-scrollbar-thumb {
        background: rgba(127, 29, 29, 0.6);
        border-radius: 8px;
    }

    #position-dropdown::-webkit-scrollbar-thumb:hover {
        background: rgba(217, 119, 6, 0.7);
    }

    #position-toggle-icon {
        transition: transform 0.2s ease;
    }

    #position-toggle-icon.rotate-180 {
        transform: rotate(180deg);
    }

    #position:-webkit-autofill,
    #position:-webkit-autofill:hover,
    #position:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 30px #1a0a0a inset !important;
        -webkit-text-fill-color: #fef3c7 !important;
    }

    input.is-invalid {
        border-color: rgba(239, 68, 68, 0.8) !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
    }

    .iti input.is-invalid {
        border-color: rgba(239, 68, 68, 0.8) !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
    }
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- Scripts: intl-tel-input + Password Toggle + Position ComboBox --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /* ═══════════════════════════════════════════════
                   Password Toggle
                   ═══════════════════════════════════════════════ */
                window.togglePassword = function(fieldId, btn) {
                    const input = document.getElementById(fieldId);
                    if (!input) return;

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    btn.innerHTML = isHidden ?
                        `<x-lucide-eye-off class="w-5 h-5" />` :
                        `<x-lucide-eye class="w-5 h-5" />`;
                };

                /* ═══════════════════════════════════════════════
                   intl-tel-input
                   ═══════════════════════════════════════════════ */
                const phoneInput = document.querySelector('#phone');
                const phoneHidden = document.querySelector('#country_code');

                if (phoneInput && typeof window.intlTelInput !== 'undefined') {
                    const iti = window.intlTelInput(phoneInput, {
                        initialCountry: 'sy',
                        preferredCountries: ['sy', 'jo', 'lb', 'sa', 'ae'],
                        separateDialCode: true,
                        utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/build/js/utils.js',
                    });

                    const phoneForm = phoneInput.closest('form');
                    if (phoneForm) {
                        phoneForm.addEventListener('submit', function() {
                            const fullNumber = iti.getNumber();
                            phoneHidden.value = fullNumber;
                            phoneInput.value = fullNumber;
                        });
                    }
                }

                /* ═══════════════════════════════════════════════
                   Position ComboBox
                   ═══════════════════════════════════════════════ */
                (function() {
                    const posInput = document.getElementById('position');
                    const dropdown = document.getElementById('position-dropdown');
                    const toggle = document.getElementById('position-toggle');
                    const icon = document.getElementById('position-toggle-icon');

                    if (!posInput || !dropdown) return;

                    const options = dropdown.querySelectorAll('.position-option');

                    function openDropdown() {
                        dropdown.classList.remove('hidden');
                        icon?.classList.add('rotate-180');
                    }

                    function closeDropdown() {
                        dropdown.classList.add('hidden');
                        icon?.classList.remove('rotate-180');
                    }

                    toggle?.addEventListener('click', function(e) {
                        e.preventDefault();
                        dropdown.classList.contains('hidden') ? openDropdown() : closeDropdown();
                    });

                    posInput.addEventListener('focus', function() {
                        if (posInput.value.trim() === '') {
                            openDropdown();
                        }
                    });

                    posInput.addEventListener('input', function() {
                        closeDropdown();
                    });

                    options.forEach(function(opt) {
                        opt.addEventListener('click', function() {
                            if (posInput.value.trim() !== '' &&
                                posInput.value.trim() !== opt.dataset.value) {
                                const confirmReplace = confirm(
                                    "You have manually entered a value. Would you like to replace it with the value selected from the list?"
                                );
                                if (!confirmReplace) {
                                    closeDropdown();
                                    return;
                                }
                            }

                            posInput.value = opt.dataset.value;
                            closeDropdown();
                            posInput.focus();
                        });
                    });

                    document.addEventListener('click', function(e) {
                        if (!posInput.contains(e.target) &&
                            !dropdown.contains(e.target) &&
                            !toggle?.contains(e.target)) {
                            closeDropdown();
                        }
                    });

                    posInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeDropdown();
                        }
                    });
                })();

            });
        </script>
    @endpush
@endonce