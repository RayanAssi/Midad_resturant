<div class="profile-panel hidden" data-panel="2fa">
    <div class="bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] rounded-2xl p-8">
        
        <div class="max-w-2xl mx-auto text-center py-8">
            
            {{-- Icon --}}
            <div class="relative inline-flex mb-6">
                <div class="absolute inset-0 bg-amber-500 rounded-3xl blur-2xl opacity-20"></div>
                <div class="relative w-20 h-20 rounded-3xl 
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Authenticator App</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Google, Authy, 1Password</p>
                </div>
                <div class="bg-black/40 border border-white/[0.06] rounded-xl p-4 text-left">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Recovery Codes</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Backup access codes</p>
                </div>
                <div class="bg-black/40 border border-white/[0.06] rounded-xl p-4 text-left">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-50">Secure Access</p>
                    <p class="text-[10px] text-amber-200/40 mt-1">Enhanced protection</p>
                </div>
            </div>

            <button type="button"
                class="group relative inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold
                       text-white overflow-hidden transition-all duration-300
                       shadow-lg shadow-amber-900/30 hover:shadow-xl hover:shadow-red-900/50
                       hover:scale-[1.02] active:scale-[0.98]">
                <span class="absolute inset-0 bg-gradient-to-r from-amber-500 via-amber-600 to-red-700"></span>
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent 
                             -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                <svg class="relative w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="relative">Enable Two-Factor Auth</span>
            </button>
        </div>
    </div>
</div>