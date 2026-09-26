@props(['action'])

<div class="profile-panel hidden" data-panel="password">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Side info --}}
        <div class="lg:col-span-2">
            <div class="relative bg-gradient-to-br from-[#1a0505] to-black border border-white/[0.06] rounded-2xl p-6 overflow-hidden">
                <div class="absolute inset-0 opacity-[0.03]"
                     style="background-image: radial-gradient(circle, #fbbf24 1px, transparent 1px); background-size: 20px 20px;"></div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-700/30 to-red-950/20 
                                border border-red-500/30 flex items-center justify-center text-red-400 mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>

                    <h2 class="text-xl font-bold text-amber-50 mb-3">{{ __('profile.security_tips') }}</h2>
                    <p class="text-sm text-amber-200/50 mb-6">
                        {{ __('profile.security_tips_desc') }}
                    </p>

                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-amber-100/70">{{ __('profile.tip_length') }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-amber-100/70">{{ __('profile.tip_mix') }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-amber-100/70">{{ __('profile.tip_avoid') }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-amber-100/70">{{ __('profile.tip_update') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="lg:col-span-3">
            <div class="bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] rounded-2xl p-8">
                <h2 class="text-xl font-bold text-amber-50 mb-1">{{ __('profile.change_password') }}</h2>
                <p class="text-sm text-amber-200/50 mb-6">{{ __('profile.change_password_desc') }}</p>

                <form method="POST" action="{{ $action }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Current Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            {{ __('profile.current_password') }}
                        </label>
                        <div class="relative">
                            <input type="password" name="current_password" data-password-input
                                autocomplete="current-password"
                                class="password-input w-full pl-4 pr-12 py-2.5 rounded-xl text-sm
                                       bg-black/40 border @error('current_password') border-red-500/50 @else border-white/[0.08] @enderror
                                       text-amber-50 placeholder-amber-200/20
                                       focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                       transition-all duration-200"
                                placeholder="{{ __('profile.current_password_ph') }}">

                            <button type="button" data-toggle-password
                                class="absolute inset-y-0 right-0 flex items-center justify-center w-11
                                       text-amber-200/40 hover:text-amber-400
                                       focus:outline-none transition-colors duration-200">
                                <x-lucide-eye class="w-5 h-5" data-eye-open />
                                <x-lucide-eye-off class="w-5 h-5 hidden" data-eye-closed />
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            {{ __('profile.new_password') }}
                        </label>
                        <div class="relative">
                            <input type="password" name="password" data-password-input
                                autocomplete="new-password"
                                class="password-input w-full pl-4 pr-12 py-2.5 rounded-xl text-sm
                                       bg-black/40 border @error('password') border-red-500/50 @else border-white/[0.08] @enderror
                                       text-amber-50 placeholder-amber-200/20
                                       focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                       transition-all duration-200"
                                placeholder="{{ __('profile.new_password_ph') }}">

                            <button type="button" data-toggle-password
                                class="absolute inset-y-0 right-0 flex items-center justify-center w-11
                                       text-amber-200/40 hover:text-amber-400
                                       focus:outline-none transition-colors duration-200">
                                <x-lucide-eye class="w-5 h-5" data-eye-open />
                                <x-lucide-eye-off class="w-5 h-5 hidden" data-eye-closed />
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            {{ __('profile.confirm_new_password') }}
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" data-password-input
                                autocomplete="new-password"
                                class="password-input w-full pl-4 pr-12 py-2.5 rounded-xl text-sm
                                       bg-black/40 border border-white/[0.08]
                                       text-amber-50 placeholder-amber-200/20
                                       focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                       transition-all duration-200"
                                placeholder="{{ __('profile.confirm_password_ph') }}">

                            <button type="button" data-toggle-password
                                class="absolute inset-y-0 right-0 flex items-center justify-center w-11
                                       text-amber-200/40 hover:text-amber-400
                                       focus:outline-none transition-colors duration-200">
                                <x-lucide-eye class="w-5 h-5" data-eye-open />
                                <x-lucide-eye-off class="w-5 h-5 hidden" data-eye-closed />
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                                   text-white overflow-hidden transition-all duration-300
                                   shadow-lg shadow-amber-900/30 hover:shadow-xl hover:shadow-red-900/50
                                   hover:scale-[1.02] active:scale-[0.98]">
                            <span class="absolute inset-0 bg-gradient-to-r from-amber-500 via-amber-600 to-red-700"></span>
                            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                                         -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                            <svg class="relative w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="relative">{{ __('profile.update_password') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    /* ✅ إصلاح خلفية Chrome عند Autofill */
    .password-input:-webkit-autofill,
    .password-input:-webkit-autofill:hover,
    .password-input:-webkit-autofill:focus,
    .password-input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px #0a0a0a inset !important;
        box-shadow: 0 0 0 1000px #0a0a0a inset !important;
        -webkit-text-fill-color: #fef3c7 !important;
        caret-color: #fef3c7 !important;
        transition: background-color 5000s ease-in-out 0s !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    .password-input:-moz-autofill,
    .password-input:-moz-autofill-preview {
        filter: none !important;
        background-color: #0a0a0a !important;
        color: #fef3c7 !important;
    }

    .password-input:-webkit-autofill::first-line {
        color: #fef3c7 !important;
        font-family: inherit !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const wrapper  = btn.closest('.relative');
                const input    = wrapper.querySelector('[data-password-input]');
                const eyeOpen  = btn.querySelector('[data-eye-open]');
                const eyeOff   = btn.querySelector('[data-eye-closed]');
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                eyeOpen.classList.toggle('hidden', isHidden);
                eyeOff.classList.toggle('hidden', !isHidden);
            });
        });
    });
</script>