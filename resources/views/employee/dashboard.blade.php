<x-layouts.employee title="Dashboard">

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50%      { opacity: 0.6;  transform: scale(1.05); }
        }
        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-4px); }
        }
        @keyframes shimmer {
            0%   { background-position: -1000px 0; }
            100% { background-position:  1000px 0; }
        }

        .anim-fadeUp { animation: fadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .anim-glow   { animation: glowPulse 5s ease-in-out infinite; }
        .anim-float  { animation: floatIcon 3.5s ease-in-out infinite; }

        .premium-card {
            position: relative;
            transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .premium-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.05) 50%, transparent 70%);
            background-size: 1000px 100%;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s;
        }
        .premium-card:hover::before {
            opacity: 1;
            animation: shimmer 1.8s linear;
        }
        .premium-card:hover {
            transform: translateY(-4px);
        }
    </style>

    <div class="w-full space-y-6">

        {{-- HERO — Welcome Banner                                     --}}
        <div class="w-full relative rounded-3xl overflow-hidden border border-amber-800/30
                    bg-gradient-to-br from-[#1a0a05] via-black to-[#0a0202]
                    shadow-2xl shadow-amber-950/20 anim-fadeUp">

            <div class="absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full
                        bg-amber-600/20 blur-3xl anim-glow"></div>
            <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] rounded-full
                        bg-red-700/20 blur-3xl anim-glow" style="animation-delay: 2.5s;"></div>

            <div class="absolute inset-0 opacity-[0.035]"
                 style="background-image: repeating-linear-gradient(45deg, #fbbf24 0, #fbbf24 1px, transparent 1px, transparent 42px);"></div>

            <div class="absolute top-0 left-0 right-0 h-[2px] 
                        bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>

            <div class="relative px-6 md:px-10 py-8 md:py-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                    <div class="flex items-center gap-5">
                        <div class="relative flex-shrink-0">
                            <div class="absolute -inset-3 bg-gradient-to-br from-amber-500 via-orange-500 to-red-700
                                        rounded-3xl blur-2xl opacity-50"></div>
                            <div class="relative w-20 h-20 md:w-24 md:h-24 rounded-3xl
                                        bg-gradient-to-br from-amber-400 via-amber-500 to-red-700
                                        flex items-center justify-center
                                        text-white text-3xl md:text-4xl font-black
                                        ring-4 ring-black/60
                                        shadow-2xl shadow-amber-900/50">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full
                                         bg-emerald-500 border-[3px] border-black
                                         flex items-center justify-center">
                                <svg class="w-3 h-3 text-black" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full 
                                             bg-amber-500/10 border border-amber-500/30
                                             text-amber-300 text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                    {{ auth()->user()->getRoleNames()->first() ?? 'Employee' }}
                                </span>
                                <span class="text-[11px] text-amber-200/40 font-mono">
                                    ID #{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <h1 class="text-3xl md:text-4xl font-black text-transparent bg-clip-text
                                       bg-gradient-to-r from-amber-200 via-amber-300 to-orange-400
                                       tracking-tight">
                                Welcome back, {{ explode(' ', auth()->user()->name)[0] }} 👋
                            </h1>

                            <p class="text-sm text-amber-200/50 mt-2 flex items-center gap-3">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ now()->translatedFormat('l، d F Y') }}
                                </span>
                                <span class="text-amber-200/20">•</span>
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ now()->format('h:i A') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @can('orders.create')
                            <a href="{{ route('employee.orders.create') }}"
                               class="group relative inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                                      text-white text-sm font-bold overflow-hidden
                                      shadow-lg shadow-emerald-950/50
                                      transition-all hover:scale-105 active:scale-95">
                                <span class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-800"></span>
                                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent
                                             -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                                <svg class="relative w-4 h-4 group-hover:rotate-90 transition-transform duration-300"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span class="relative">New Order</span>
                            </a>
                        @endcan
                        @can('expenses.create')
                            <a href="{{ route('employee.expenses.create') }}"
                               class="group inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                                      bg-black/40 border-2 border-amber-700/40
                                      hover:border-amber-500/60 hover:bg-amber-900/20
                                      text-amber-200 text-sm font-bold
                                      transition-all hover:scale-105 active:scale-95">
                                <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                New Expense
                            </a>
                        @endcan
                    </div>

                </div>
            </div>
        </div>

        {{-- ORDERS — Big Featured Card                              --}}
        @can('orders.view')
            <div class="w-full premium-card rounded-3xl overflow-hidden anim-fadeUp
                        border border-red-900/40 shadow-2xl shadow-red-950/40
                        bg-gradient-to-br from-[#150404] via-black to-black"
                 style="animation-delay: 0.1s;">

                <div class="h-1 bg-gradient-to-r from-red-500 via-orange-500 to-amber-500"></div>

                <div class="px-6 md:px-8 py-6 flex items-center justify-between
                            bg-gradient-to-r from-red-950/30 via-transparent to-transparent
                            border-b border-red-900/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600/30 to-red-900/20
                                    border border-red-500/40 flex items-center justify-center
                                    text-red-400 shadow-lg shadow-red-950/50 anim-float">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-red-100">Orders</h2>
                            <p class="text-xs text-red-300/50 font-medium mt-0.5">Today's orders & revenue</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.orders.index') }}"
                       class="group hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl
                              bg-red-500/10 border border-red-500/30
                              hover:bg-red-500/20 hover:border-red-400/50
                              text-red-300 text-sm font-bold transition-all">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="group relative p-6 rounded-2xl bg-black/40 
                                    border border-red-900/30 
                                    hover:border-red-600/50 hover:bg-red-950/20 
                                    transition-all overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full blur-3xl"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-[11px] text-red-300/60 font-bold uppercase tracking-wider">Total Orders</p>
                                    <svg class="w-4 h-4 text-red-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <p class="text-5xl font-black text-transparent bg-clip-text
                                          bg-gradient-to-br from-red-200 to-red-500 tracking-tighter">
                                    {{ number_format($stats['orders']['total'] ?? 0) }}
                                </p>
                            </div>
                        </div>

                        <div class="group relative p-6 rounded-2xl bg-black/40 
                                    border border-amber-900/30 
                                    hover:border-amber-600/50 hover:bg-amber-950/20 
                                    transition-all overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-[11px] text-amber-300/60 font-bold uppercase tracking-wider">Today</p>
                                    <svg class="w-4 h-4 text-amber-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-5xl font-black text-transparent bg-clip-text
                                          bg-gradient-to-br from-amber-200 to-orange-500 tracking-tighter">
                                    {{ number_format($stats['orders']['today'] ?? 0) }}
                                </p>
                            </div>
                        </div>

                        <div class="group relative p-6 rounded-2xl bg-black/40 
                                    border border-emerald-900/30 
                                    hover:border-emerald-600/50 hover:bg-emerald-950/20 
                                    transition-all overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-[11px] text-emerald-300/60 font-bold uppercase tracking-wider">Revenue</p>
                                    <svg class="w-4 h-4 text-emerald-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-3xl font-black text-transparent bg-clip-text
                                          bg-gradient-to-br from-emerald-200 to-teal-500 tracking-tight">
                                    {{ number_format($stats['orders']['revenue'] ?? 0, 2) }}
                                </p>
                                <p class="text-[10px] text-emerald-300/40 font-bold uppercase tracking-wider mt-1">SYP</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endcan

        {{-- INVOICES — Full Width Card                                --}}
        @can('invoices.view')
            <div class="w-full premium-card rounded-3xl overflow-hidden anim-fadeUp
                        border border-amber-900/40 shadow-2xl shadow-amber-950/40
                        bg-gradient-to-br from-[#150d04] via-black to-black"
                 style="animation-delay: 0.2s;">

                <div class="h-1 bg-gradient-to-r from-amber-400 via-orange-500 to-red-500"></div>

                <div class="px-6 md:px-8 py-6 flex items-center justify-between
                            bg-gradient-to-r from-amber-950/30 via-transparent to-transparent
                            border-b border-amber-900/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-600/30 to-amber-900/20
                                    border border-amber-500/40 flex items-center justify-center
                                    text-amber-400 shadow-lg shadow-amber-950/50 anim-float">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-amber-100">Invoices</h2>
                            <p class="text-xs text-amber-300/50 font-medium mt-0.5">Your issued invoices</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.invoices.index') }}"
                       class="group hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl
                              bg-amber-500/10 border border-amber-500/30
                              hover:bg-amber-500/20 hover:border-amber-400/50
                              text-amber-300 text-sm font-bold transition-all">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="p-6 rounded-2xl bg-black/40 border border-amber-900/30
                                hover:border-amber-600/50 hover:bg-amber-950/20 transition-all">
                        <p class="text-[11px] text-amber-300/60 font-bold uppercase tracking-wider mb-3">My Invoices</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-amber-200 to-amber-500 tracking-tighter">
                            {{ number_format($stats['invoices']['total'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-black/40 border border-orange-900/30
                                hover:border-orange-600/50 hover:bg-orange-950/20 transition-all">
                        <p class="text-[11px] text-orange-300/60 font-bold uppercase tracking-wider mb-3">Today</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-orange-200 to-orange-500 tracking-tighter">
                            {{ number_format($stats['invoices']['today'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-black/40 border border-emerald-900/30
                                hover:border-emerald-600/50 hover:bg-emerald-950/20 transition-all">
                        <p class="text-[11px] text-emerald-300/60 font-bold uppercase tracking-wider mb-3">Revenue</p>
                        <p class="text-3xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-emerald-200 to-teal-500 tracking-tight">
                            {{ number_format($stats['invoices']['revenue'] ?? 0, 2) }}
                        </p>
                        <p class="text-[10px] text-emerald-300/40 font-bold uppercase tracking-wider mt-1">SYP</p>
                    </div>

                </div>
            </div>
        @endcan

               {{-- MENU ITEMS — Full Width                                  --}}
        @can('menu-items.view')
            <div class="w-full premium-card rounded-3xl overflow-hidden anim-fadeUp
                        border border-blue-900/40 shadow-2xl shadow-blue-950/40
                        bg-gradient-to-br from-[#040a1a] via-black to-black"
                 style="animation-delay: 0.3s;">

                <div class="h-1 bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600"></div>

                <div class="px-6 md:px-8 py-6 flex items-center justify-between
                            bg-gradient-to-r from-blue-950/30 via-transparent to-transparent
                            border-b border-blue-900/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600/30 to-blue-900/20
                                    border border-blue-500/40 flex items-center justify-center
                                    text-blue-400 shadow-lg shadow-blue-950/50 anim-float">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-blue-100">Menu Items</h2>
                            <p class="text-xs text-blue-300/50 font-medium mt-0.5">Total dishes available</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.menu-items.index') }}"
                       class="group hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl
                              bg-blue-500/10 border border-blue-500/30
                              hover:bg-blue-500/20 hover:border-blue-400/50
                              text-blue-300 text-sm font-bold transition-all">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <div class="p-6 rounded-2xl bg-black/40 border border-blue-900/30
                                hover:border-blue-600/50 hover:bg-blue-950/20 
                                transition-all text-center">
                        <p class="text-[11px] text-blue-300/60 font-bold uppercase tracking-wider mb-3">Total Items</p>
                        <p class="text-6xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-blue-200 to-blue-500 tracking-tighter">
                            {{ number_format($stats['menu']['total'] ?? 0) }}
                        </p>
                    </div>
                </div>
            </div>
        @endcan

        {{-- DAILY EXPENSES — Full Width                              --}}
        @can('expenses.view')
            <div class="w-full premium-card rounded-3xl overflow-hidden anim-fadeUp
                        border border-orange-900/40 shadow-2xl shadow-orange-950/40
                        bg-gradient-to-br from-[#150804] via-black to-black"
                 style="animation-delay: 0.4s;">

                <div class="h-1 bg-gradient-to-r from-orange-400 via-red-500 to-rose-600"></div>

                <div class="px-6 md:px-8 py-6 flex items-center justify-between
                            bg-gradient-to-r from-orange-950/30 via-transparent to-transparent
                            border-b border-orange-900/30">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-600/30 to-orange-900/20
                                    border border-orange-500/40 flex items-center justify-center
                                    text-orange-400 shadow-lg shadow-orange-950/50 anim-float">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-orange-100">Daily Expenses</h2>
                            <p class="text-xs text-orange-300/50 font-medium mt-0.5">Track your spending</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.expenses.index') }}"
                       class="group hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl
                              bg-orange-500/10 border border-orange-500/30
                              hover:bg-orange-500/20 hover:border-orange-400/50
                              text-orange-300 text-sm font-bold transition-all">
                        View All
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-6 rounded-2xl bg-black/40 border border-orange-900/30
                                hover:border-orange-600/50 hover:bg-orange-950/20 transition-all text-center">
                        <p class="text-[11px] text-orange-300/60 font-bold uppercase tracking-wider mb-3">Records</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-orange-200 to-orange-500 tracking-tighter">
                            {{ number_format($stats['expenses']['count'] ?? 0) }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-black/40 border border-red-900/30
                                hover:border-red-600/50 hover:bg-red-950/20 transition-all text-center">
                        <p class="text-[11px] text-red-300/60 font-bold uppercase tracking-wider mb-3">Today</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-red-200 to-red-500 tracking-tighter">
                            {{ number_format($stats['expenses']['today'] ?? 0, 0) }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-black/40 border border-rose-900/30
                                hover:border-rose-600/50 hover:bg-rose-950/20 transition-all text-center">
                        <p class="text-[11px] text-rose-300/60 font-bold uppercase tracking-wider mb-3">Total</p>
                        <p class="text-5xl font-black text-transparent bg-clip-text
                                  bg-gradient-to-br from-rose-200 to-rose-500 tracking-tighter">
                            {{ number_format($stats['expenses']['total'] ?? 0, 0) }}
                        </p>
                    </div>
                </div>
            </div>
        @endcan

    </div>

</x-layouts.employee>
