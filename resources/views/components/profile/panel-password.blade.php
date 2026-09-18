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


                {{-- ✅ General error --}}
                {{-- @if($errors->any())
                    <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl
                                bg-red-500/10 border border-red-500/30 text-red-300">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm font-medium">
                            Please fix the errors below.
                        </div>
                    </div>
                @endif --}}

                <form method="POST" action="{{ $action }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            Current Password
                        </label>
                        <input type="password" name="current_password"
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-black/40 border @error('current_password') border-red-500/50 @else border-white/[0.08] @enderror
                                   text-amber-50 placeholder-amber-200/20
                                   focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                   transition-all duration-200"
                            placeholder="Enter your current password">
                        @error('current_password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            New Password
                        </label>
                        <input type="password" name="password"
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 rounded-xl text-sm
                                   bg-black/40 border @error('password') border-red-500/50 @else border-white/[0.08] @enderror
                                   text-amber-50 placeholder-amber-200/20
                                   focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/10
                                   transition-all duration-200"
                            placeholder="Enter a new password">
                        @error('password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-amber-200/60 uppercase tracking-wider mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="password_confirmation"
                            autocomplete="new-password"
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