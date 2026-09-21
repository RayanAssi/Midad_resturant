<x-layouts.employee title="Profile">

    <div class="max-w-7xl mx-auto px-2">
        <x-flash-message />
        {{-- ============================================================ --}}
        {{-- HERO SECTION --}}
        {{-- ============================================================ --}}
        <div class="relative rounded-3xl overflow-hidden mb-8 border border-white/[0.06]">

            <div class="absolute inset-0 bg-gradient-to-br from-[#1a0505] via-[#0a0505] to-black"></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_rgba(220,38,38,0.25),_transparent_50%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_rgba(245,158,11,0.15),_transparent_50%)]">
            </div>

            <div class="absolute inset-0 opacity-[0.04]"
                style="background-image: repeating-linear-gradient(45deg, #fbbf24 0, #fbbf24 1px, transparent 1px, transparent 40px);">
            </div>

            <div class="relative px-8 py-10 md:px-12 md:py-14">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-8">

                    {{-- Avatar --}}
                    <div class="relative flex-shrink-0">
                        <div
                            class="absolute -inset-2 bg-gradient-to-br from-amber-500 to-red-700 rounded-3xl blur-2xl opacity-40">
                        </div>
                        <div
                            class="relative w-28 h-28 md:w-32 md:h-32 rounded-3xl
                                    bg-gradient-to-br from-amber-400 via-amber-500 to-red-700
                                    flex items-center justify-center
                                    text-white text-4xl md:text-5xl font-black
                                    ring-4 ring-black/50
                                    shadow-2xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl 
                                    bg-black border-2 border-emerald-500/50 p-1.5">
                            <div class="w-full h-full rounded-xl bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-3">
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
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
                                <svg class="w-4 h-4 text-amber-200/40" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-amber-200/60">
                                    Joined {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                            <div class="w-px h-4 bg-white/10"></div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-200/40" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-amber-200/60">Account Verified</span>
                            </div>
                        </div>
                    </div>

                    {{-- (No Edit Button for employee) --}}
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TAB NAVIGATION (Account + 2FA only) --}}
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

        </div>

        {{-- ============================================================ --}}
        {{-- PANELS (components) --}}
        {{-- ============================================================ --}}
        <x-profile.panel-account :user="$user" />
        <x-profile.panel-2fa 
        :user="$user"
        mode="form"
        :enable-route="route('two-factor.enable')"
        :disable-route="route('two-factor.disable')"
        />
    </div>

    {{-- ==================== Styles ==================== --}}
    <style>
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

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(245, 158, 11, 0.4), rgba(220, 38, 38, 0.4));
            border-radius: 3px;
        }
    </style>

    {{-- ==================== Script ==================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.profile-tab');
            const panels = document.querySelectorAll('.profile-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    panels.forEach(p => p.classList.add('hidden'));

                    const targetPanel = document.querySelector(
                        `.profile-panel[data-panel="${target}"]`);
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

</x-layouts.employee>
