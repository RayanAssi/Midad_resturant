@props(['user'])

<div class="profile-panel hidden" data-panel="2fa">
    <div class="bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] rounded-2xl p-8">

        <div class="max-w-2xl mx-auto text-center py-8">

            {{-- Icon --}}
            <div class="relative inline-flex mb-6">
                <div class="absolute inset-0 bg-amber-500 rounded-3xl blur-2xl opacity-20"></div>
                <div
                    class="relative w-20 h-20 rounded-3xl 
                            bg-gradient-to-br from-amber-500/20 to-red-700/10
                            border border-amber-500/30
                            flex items-center justify-center text-amber-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-amber-50 mb-3">Two-Factor Authentication</h2>
            <p class="text-sm text-amber-200/50 max-w-md mx-auto mb-8">
                Protect your account with an extra layer of security. Once enabled,
                you'll be required to enter a 6-digit code from your authenticator app.
            </p>

            {{-- Feature list --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-8">
                <div class="bg-black/40 border border-white/[0.06] rounded-xl p-4 text-left">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Authenticator App</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Google, Authy, 1Password</p>
                </div>
                <div class="bg-black/40 border border-white/[0.06] rounded-xl p-4 text-left">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Recovery Codes</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Backup access codes</p>
                </div>
                <div class="bg-black/40 border border-white/[0.06] rounded-xl p-4 text-left">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Secure Access</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Enhanced protection</p>
                </div>
            </div>

            {{-- ==================== الحالة: غير مفعّل ==================== --}}
            @if (!$user->two_factor_secret)
                <button type="button" onclick="openConfirmPasswordModal('enable')"
                    class="group relative inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold
                           text-white overflow-hidden transition-all duration-300
                           shadow-lg shadow-amber-900/30 hover:shadow-xl hover:shadow-red-900/50
                           hover:scale-[1.02] active:scale-[0.98]">
                    <span class="absolute inset-0 bg-gradient-to-r from-amber-500 via-amber-600 to-red-700"></span>
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                                 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                    <svg class="relative w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="relative">Enable Two-Factor Auth</span>
                </button>
            @else
                {{-- ✅ الحالة: مفعّل --}}
                <div class="space-y-6 text-left">

                    {{-- ═══════════ Status Hero ═══════════ --}}
                    <div
                        class="relative overflow-hidden rounded-2xl
                    bg-gradient-to-r from-emerald-950/40 via-[#0f0f0f] to-[#0f0f0f]
                    border border-emerald-500/20 p-5">

                        <div class="absolute -top-20 -left-20 w-40 h-40 rounded-full bg-emerald-500/10 blur-3xl"></div>

                        <div class="relative flex items-center gap-4">
                            <div class="relative flex-shrink-0">
                                <div class="absolute inset-0 rounded-2xl bg-emerald-500 blur-xl opacity-40"></div>
                                <div
                                    class="relative w-12 h-12 rounded-2xl 
                                bg-gradient-to-br from-emerald-400 to-emerald-600
                                flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-emerald-100">Account Protected</h3>
                                <p class="text-xs text-emerald-300/60 mt-0.5">
                                    Two-factor authentication is active on this account.
                                </p>
                            </div>
                            <span
                                class="flex-shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                             text-[10px] font-bold uppercase tracking-wider
                             bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-400"></span>
                                </span>
                                Active
                            </span>
                        </div>
                    </div>

                    {{-- ═══════════ Main Grid ═══════════ --}}
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

                        {{-- ═══ QR Code Card ═══ --}}
                        <div
                            class="lg:col-span-3 relative overflow-hidden rounded-2xl
                        bg-[#0a0a0a] border border-white/[0.06]
                        hover:border-amber-500/30 transition-all duration-500 group">

                            <div
                                class="absolute -top-32 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full 
                            bg-amber-500/10 blur-3xl
                            group-hover:bg-amber-500/15 transition-all duration-500">
                            </div>

                            <div class="relative p-6">

                                {{-- Header --}}
                                <div class="mb-6">
                                    <h3 class="text-sm font-bold text-amber-50">Authenticator Setup</h3>
                                    <p class="text-[10px] text-amber-200/40 mt-0.5">
                                        Scan with Google, Authy, or 1Password
                                    </p>
                                </div>

                                {{-- QR --}}
                                <div class="flex justify-center mb-6">
                                    <div class="relative">
                                        <div
                                            class="absolute -inset-3 rounded-3xl bg-gradient-to-br from-amber-500/30 via-amber-600/20 to-red-700/30 blur-2xl opacity-60">
                                        </div>

                                        <div
                                            class="relative p-[3px] rounded-2xl
                                        bg-gradient-to-br from-amber-400 via-amber-500 to-red-700
                                        shadow-2xl shadow-amber-900/50">
                                            <div class="bg-white p-4 rounded-[13px]">
                                                {!! $user->twoFactorQrCodeSvg() !!}
                                            </div>
                                        </div>

                                        <div
                                            class="absolute -top-1 -left-1 w-4 h-4 border-t-2 border-l-2 border-amber-400 rounded-tl-lg">
                                        </div>
                                        <div
                                            class="absolute -top-1 -right-1 w-4 h-4 border-t-2 border-r-2 border-amber-400 rounded-tr-lg">
                                        </div>
                                        <div
                                            class="absolute -bottom-1 -left-1 w-4 h-4 border-b-2 border-l-2 border-amber-400 rounded-bl-lg">
                                        </div>
                                        <div
                                            class="absolute -bottom-1 -right-1 w-4 h-4 border-b-2 border-r-2 border-amber-400 rounded-br-lg">
                                        </div>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="flex-1 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent">
                                    </div>
                                    <span class="text-[9px] uppercase tracking-[0.2em] text-amber-200/30 font-bold">
                                        Or manually
                                    </span>
                                    <div
                                        class="flex-1 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent">
                                    </div>
                                </div>

                                {{-- Secret Key --}}
                                <div class="relative group/key">
                                    <div
                                        class="flex items-center gap-2 px-4 py-3 rounded-xl
                                    bg-black border border-white/[0.06]
                                    hover:border-amber-500/30 transition-all">
                                        <svg class="w-4 h-4 text-amber-500/50 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        <code class="flex-1 text-amber-200 text-xs font-mono tracking-wider break-all">
                                            {{ decrypt($user->two_factor_secret) }}
                                        </code>
                                        <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ decrypt($user->two_factor_secret) }}'); this.querySelector('.copy-text').innerText='Copied!'; setTimeout(() => this.querySelector('.copy-text').innerText='Copy', 1500);"
                                            class="flex-shrink-0 flex items-center gap-1.5 px-2.5 py-1 rounded-lg
                                       text-[10px] font-semibold
                                       bg-amber-500/10 hover:bg-amber-500/20
                                       border border-amber-500/20 hover:border-amber-500/40
                                       text-amber-300
                                       transition-all">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <span class="copy-text">Copy</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- ═══ Recovery Codes Card (scroll جوّا القائمة فقط) ═══ --}}
                        <div
                            class="lg:col-span-2 relative overflow-hidden rounded-2xl
                        bg-[#0a0a0a] border border-white/[0.06]
                        hover:border-red-500/30 transition-all duration-500 group
                        flex flex-col">

                            <div
                                class="absolute -bottom-32 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full 
                            bg-red-500/10 blur-3xl
                            group-hover:bg-red-500/15 transition-all duration-500">
                            </div>

                            <div class="relative p-6 flex flex-col flex-1 min-h-0">

                                {{-- Header (ثابت) --}}
                                <div class="flex items-center gap-3 mb-4 flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-xl 
                                    bg-gradient-to-br from-red-500 to-red-700
                                    flex items-center justify-center
                                    shadow-lg shadow-red-900/40">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-amber-50">Recovery Codes</h3>
                                        <p class="text-[10px] text-amber-200/40 mt-0.5">Emergency access</p>
                                    </div>
                                </div>

                                {{-- Warning (ثابت) --}}
                                <div
                                    class="mb-4 flex items-start gap-2 px-3 py-2.5 rounded-xl flex-shrink-0
                                bg-gradient-to-r from-amber-950/50 to-transparent
                                border border-amber-500/20">
                                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-[10px] text-amber-200/70 leading-relaxed">
                                        Keep these safe. Each can be used once.
                                    </p>
                                </div>

                                {{-- Codes List (scroll هنا فقط) --}}
                                {{-- Codes (with scroll — 5 ظاهرة، والباقي سكرول) --}}
<div class="relative">

    {{-- Fade bottom --}}
    <div class="absolute bottom-0 left-0 right-0 h-6 z-10 pointer-events-none
                bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent"></div>

    <div class="recovery-scroll overflow-y-auto pl-1 pr-2 space-y-1.5" 
         style="max-height: 220px;">
        @foreach ($user->recoveryCodes() as $index => $code)
            <div class="group/code flex items-center gap-3 px-3 py-2 rounded-lg
                        bg-black/60 border border-white/[0.04]
                        hover:bg-black/90 hover:border-red-500/20
                        transition-all duration-200">
                <span class="flex-shrink-0 w-6 h-6 rounded-md
                            bg-gradient-to-br from-red-500/20 to-red-700/10
                            border border-red-500/30
                            flex items-center justify-center
                            text-[9px] font-bold text-red-300">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
                <code class="flex-1 text-amber-100 text-xs font-mono tracking-wider">
                    {{ $code }}
                </code>
                <button type="button"
                    onclick="navigator.clipboard.writeText('{{ $code }}');"
                    class="opacity-0 group-hover/code:opacity-100 transition-opacity
                           text-amber-500/50 hover:text-amber-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
        @endforeach
    </div>
</div>

                            </div>
                        </div>

                    </div>

                    {{-- ═══════════ Disable Button ═══════════ --}}
                    <div class="flex justify-center pt-2">
                        <button type="button" onclick="openConfirmPasswordModal('disable')"
                            class="group relative inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold
                       text-red-300
                       bg-gradient-to-r from-red-950/60 to-red-900/30
                       border border-red-500/30 hover:border-red-500/60
                       transition-all duration-300
                       hover:shadow-xl hover:shadow-red-950/60
                       hover:scale-[1.02] active:scale-[0.98]">
                            <span
                                class="absolute inset-0 rounded-xl bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 
                             opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            <svg class="relative w-4 h-4 group-hover:rotate-90 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            <span class="relative">Disable Two-Factor Auth</span>
                        </button>
                    </div>

                </div>
            @endif

        </div>
    </div>
</div>

{{-- Confirm Password Modal --}}
<div id="confirmPasswordModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4"
    style="background: rgba(0,0,0,0.75); backdrop-filter: blur(8px);">

    <div
        class="relative w-full max-w-md bg-[#0f0f0f]/95 backdrop-blur-xl border border-white/[0.08] rounded-2xl p-8 shadow-2xl">

        <div class="flex justify-center mb-5">
            <div id="modalIcon"
                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500/20 to-red-700/10 
                        border border-amber-500/30 flex items-center justify-center text-amber-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <h3 id="modalTitle" class="text-xl font-bold text-amber-50 text-center mb-2">Confirm Password</h3>
        <p id="modalDesc" class="text-sm text-amber-200/50 text-center mb-6">
            Please confirm your password before enabling Two-Factor Authentication.
        </p>

        <form id="confirmPasswordForm" method="POST" action="{{ route('admin.two-factor.enable') }}"
            class="space-y-5">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div>
                <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                    Password
                </label>
                <input type="password" name="password" autocomplete="current-password" autofocus
                    class="w-full px-4 py-2.5 rounded-xl text-sm
                           bg-black/40 border @error('password') border-red-500/50 @else border-white/[0.08] @enderror
                           text-amber-50 placeholder-amber-200/20
                           focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10"
                    placeholder="Enter your password">
                @error('password')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" onclick="closeConfirmPasswordModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold
                           bg-white/[0.03] hover:bg-white/[0.06]
                           border border-white/[0.08]
                           text-amber-100 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" id="modalSubmitBtn"
                    class="flex-1 relative inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                           text-white overflow-hidden transition-all duration-300">
                    <span class="absolute inset-0 bg-gradient-to-r from-amber-500 via-amber-600 to-red-700"></span>
                    <span class="relative">Confirm</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .recovery-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .recovery-scroll::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.4);
        border-radius: 2px;
    }

    .recovery-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, rgba(220, 38, 38, 0.5), rgba(245, 158, 11, 0.5));
        border-radius: 2px;
    }

    .recovery-scroll::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, rgba(220, 38, 38, 0.8), rgba(245, 158, 11, 0.8));
    }
</style>

<script>
    const enableRoute = "{{ route('admin.two-factor.enable') }}";
    const disableRoute = "{{ route('admin.two-factor.disable') }}";

    function openConfirmPasswordModal(action) {
        const modal = document.getElementById('confirmPasswordModal');
        const form = document.getElementById('confirmPasswordForm');
        const method = document.getElementById('formMethod');
        const title = document.getElementById('modalTitle');
        const desc = document.getElementById('modalDesc');
        const submitBtn = document.getElementById('modalSubmitBtn');
        const icon = document.getElementById('modalIcon');

        if (action === 'disable') {
            form.action = disableRoute;
            method.value = 'DELETE';
            title.textContent = 'Disable Two-Factor';
            desc.textContent = 'Please confirm your password before disabling Two-Factor Authentication.';
            submitBtn.querySelector('.relative').textContent = 'Disable';
            icon.className =
                "w-16 h-16 rounded-2xl bg-gradient-to-br from-red-500/20 to-red-700/10 border border-red-500/30 flex items-center justify-center text-red-400";
        } else {
            form.action = enableRoute;
            method.value = 'POST';
            title.textContent = 'Confirm Password';
            desc.textContent = 'Please confirm your password before enabling Two-Factor Authentication.';
            submitBtn.querySelector('.relative').textContent = 'Confirm';
            icon.className =
                "w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500/20 to-red-700/10 border border-amber-500/30 flex items-center justify-center text-amber-400";
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            const input = modal.querySelector('input[name="password"]');
            if (input) input.focus();
        }, 100);
    }

    function closeConfirmPasswordModal() {
        const modal = document.getElementById('confirmPasswordModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeConfirmPasswordModal();
    });

    document.getElementById('confirmPasswordModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeConfirmPasswordModal();
    });

    @if ($errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            const tab2fa = document.querySelector('.profile-tab[data-tab="2fa"]');
            if (tab2fa) tab2fa.click();
            openConfirmPasswordModal('enable');
        });
    @endif
</script>