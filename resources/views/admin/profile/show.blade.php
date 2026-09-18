<x-layouts.admin title="Profile">

    <div class="max-w-7xl mx-auto px-2">

        {{-- ============================================================ --}}
        {{-- HERO SECTION --}}
        {{-- ============================================================ --}}
        <div class="relative rounded-3xl overflow-hidden mb-8 border border-white/[0.06]">
            
            {{-- Background layers --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#1a0505] via-[#0a0505] to-black"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_rgba(220,38,38,0.25),_transparent_50%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_rgba(245,158,11,0.15),_transparent_50%)]"></div>
            
            {{-- Diagonal lines pattern --}}
            <div class="absolute inset-0 opacity-[0.04]"
                 style="background-image: repeating-linear-gradient(45deg, #fbbf24 0, #fbbf24 1px, transparent 1px, transparent 40px);"></div>

            {{-- Content --}}
            <div class="relative px-8 py-10 md:px-12 md:py-14">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-8">

                    {{-- Avatar --}}
                    <div class="relative flex-shrink-0">
                        <div class="absolute -inset-2 bg-gradient-to-br from-amber-500 to-red-700 rounded-3xl blur-2xl opacity-40"></div>
                        <div class="relative w-28 h-28 md:w-32 md:h-32 rounded-3xl
                                    bg-gradient-to-br from-amber-400 via-amber-500 to-red-700
                                    flex items-center justify-center
                                    text-white text-4xl md:text-5xl font-black
                                    ring-4 ring-black/50
                                    shadow-2xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl 
                                    bg-black border-2 border-emerald-500/50 p-1.5">
                            <div class="w-full h-full rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                         bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                Active Account
                            </span>
                            <span class="text-[11px] text-amber-200/40 font-mono">
                                ID #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-amber-50 tracking-tight">
                            {{ $user->name }}
                        </h1>
                        <p class="text-sm md:text-base text-amber-200/50 mt-2">{{ $user->email }}</p>

                        {{-- Quick Stats --}}
                        <div class="flex flex-wrap items-center gap-6 mt-6">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-200/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-amber-200/60">
                                    Joined {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                            <div class="w-px h-4 bg-white/10"></div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-200/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-amber-200/60">Account Verified</span>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Button --}}
                    <div class="flex-shrink-0">
                        <button type="button"
                            class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                                   bg-white/[0.03] hover:bg-white/[0.06]
                                   border border-white/[0.08] hover:border-amber-500/30
                                   text-amber-100 hover:text-white
                                   transition-all duration-300">
                            <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TAB NAVIGATION (Horizontal Pills) --}}
        {{-- ============================================================ --}}
        <div class="mb-6 flex items-center gap-2 overflow-x-auto pb-1" id="profileTabs">
            
            <button type="button" data-tab="account"
                class="profile-tab active flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Account
            </button>

            <button type="button" data-tab="2fa"
                class="profile-tab flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Two-Factor
            </button>

            <button type="button" data-tab="password"
                class="profile-tab flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Password
            </button>
        </div>

        {{-- ============================================================ --}}
        {{-- PANELS --}}
        {{-- ============================================================ --}}

        {{-- ============ Panel: Account (Bento Grid) ============ --}}
        <div class="profile-panel" data-panel="account">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Card: Full Name --}}
                <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                            rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300">
                    
                    {{-- Number badge --}}
                    <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                        01
                    </span>
                    
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/15 to-red-700/10 
                                border border-amber-500/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <div class="relative">
                        <p class="text-[10px] uppercase tracking-[0.15em] text-amber-200/40 font-semibold mb-2">Full Name</p>
                        <p class="text-lg font-bold text-amber-50 break-words">{{ $user->name }}</p>
                    </div>
                </div>

                {{-- Card: Email --}}
                <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                            rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300
                            md:col-span-2">
                    
                    <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                        02
                    </span>
                    
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/15 to-red-700/10 
                                        border border-amber-500/20 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-[10px] uppercase tracking-[0.15em] text-amber-200/40 font-semibold mb-2">Email Address</p>
                            <p class="text-lg font-bold text-amber-50 break-words">{{ $user->email }}</p>
                        </div>
                        
                        @if($user->email_verified_at)
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                         bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                         bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                Pending
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card: Member Since --}}
                <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                            rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300">
                    
                    <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                        03
                    </span>
                    
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/15 to-red-700/10 
                                border border-amber-500/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-amber-200/40 font-semibold mb-2">Member Since</p>
                    <p class="text-lg font-bold text-amber-50">{{ $user->created_at->format('F d, Y') }}</p>
                    <p class="text-xs text-amber-200/40 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                </div>

                {{-- Card: Role/Type --}}
                <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                            rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300">
                    
                    <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                        04
                    </span>
                    
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/15 to-red-700/10 
                                border border-amber-500/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-amber-200/40 font-semibold mb-2">Account Type</p>
                    <p class="text-lg font-bold text-amber-50">{{ ucfirst($user->role ?? 'Member') }}</p>
                    <p class="text-xs text-amber-200/40 mt-1">Full access</p>
                </div>

                {{-- Card: Account ID --}}
                <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                            rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300">
                    
                    <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                        05
                    </span>
                    
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500/15 to-red-700/10 
                                border border-amber-500/20 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.15em] text-amber-200/40 font-semibold mb-2">Account ID</p>
                    <p class="text-lg font-bold text-amber-50 font-mono">
                        #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ============ Panel: 2FA ============ --}}
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

        {{-- ============ Panel: Password ============ --}}
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

                            <h2 class="text-xl font-bold text-amber-50 mb-3">Security Tips</h2>
                            <p class="text-sm text-amber-200/50 mb-6">
                                Keep your account safe by following these practices:
                            </p>

                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-amber-100/70">Use at least 12 characters</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-amber-100/70">Mix letters, numbers & symbols</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-amber-100/70">Avoid common words</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-amber-100/70">Update regularly</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] rounded-2xl p-8">
                        <h2 class="text-xl font-bold text-amber-50 mb-1">Change Password</h2>
                        <p class="text-sm text-amber-200/50 mb-6">Update your account password below.</p>

                        <form class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                                    Current Password
                                </label>
                                <input type="password" name="current_password"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-black/40 border border-white/[0.08]
                                           text-amber-50 placeholder-amber-200/20
                                           focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                           transition-all duration-200"
                                    placeholder="Enter your current password">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                                    New Password
                                </label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-black/40 border border-white/[0.08]
                                           text-amber-50 placeholder-amber-200/20
                                           focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                           transition-all duration-200"
                                    placeholder="Enter a new password">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                                    Confirm New Password
                                </label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm
                                           bg-black/40 border border-white/[0.08]
                                           text-amber-50 placeholder-amber-200/20
                                           focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                           transition-all duration-200"
                                    placeholder="Repeat the new password">
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
                                    <span class="relative">Update Password</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ==================== Styles ==================== --}}
    <style>
        /* Tab buttons */
        .profile-tab {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(254, 243, 199, 0.5);
        }
        .profile-tab:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #fef3c7;
            border-color: rgba(245, 158, 11, 0.2);
        }
        .profile-tab.active {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(220, 38, 38, 0.15));
            border-color: rgba(245, 158, 11, 0.4);
            color: #fef3c7;
            box-shadow: 
                0 4px 20px -4px rgba(245, 158, 11, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        /* Panel animation */
        .profile-panel {
            animation: panelSlide 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @keyframes panelSlide {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.3); }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(245, 158, 11, 0.4), rgba(220, 38, 38, 0.4));
            border-radius: 3px;
        }
    </style>

    {{-- ==================== Script ==================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.profile-tab');
            const panels = document.querySelectorAll('.profile-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    panels.forEach(p => p.classList.add('hidden'));
                    
                    const targetPanel = document.querySelector(`.profile-panel[data-panel="${target}"]`);
                    if (targetPanel) {
                        targetPanel.classList.remove('hidden');
                        targetPanel.style.animation = 'none';
                        targetPanel.offsetHeight;
                        targetPanel.style.animation = '';
                    }
                });
            });
        });
    </script>

</x-layouts.admin>