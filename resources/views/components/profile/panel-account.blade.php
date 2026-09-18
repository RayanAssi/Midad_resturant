@props(['user'])

<div class="profile-panel" data-panel="account">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Card: Full Name --}}
        <div class="group relative bg-[#0f0f0f]/80 backdrop-blur-xl border border-white/[0.06] 
                    rounded-2xl p-6 overflow-hidden hover:border-amber-500/20 transition-all duration-300">
            
            <span class="absolute top-4 right-4 text-[60px] font-black text-white/[0.02] leading-none select-none">
                01
            </span>
            
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