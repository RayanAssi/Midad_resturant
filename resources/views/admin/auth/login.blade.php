<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin_auth.title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        .grid-bg {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .glow-line {
            background: linear-gradient(90deg, transparent, #dc2626, transparent);
        }
    </style>
</head>

<body class="min-h-screen bg-[#08080a] text-gray-200 flex items-center justify-center p-4 relative overflow-hidden">

    {{-- Subtle grid background --}}
    <div class="absolute inset-0 grid-bg pointer-events-none"></div>

    {{-- Top center glow --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] 
                bg-red-600/10 rounded-full blur-[100px] pointer-events-none">
    </div>

    {{-- Content --}}
    <div class="relative w-full max-w-[420px]">

        {{-- ═══ Language Switcher ═══ --}}
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center gap-1 p-1 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                @foreach (config('laravellocalization.supportedLocales') as $code => $locale)
                    <a href="{{ route('locale.switch', $code) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200
                              {{ app()->getLocale() === $code
                                  ? 'bg-red-600 text-white shadow-lg shadow-red-900/30'
                                  : 'text-gray-500 hover:text-white hover:bg-white/[0.05]' }}">
                        {{ $locale['native'] }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Logo and title --}}
        <div class="text-center mb-8">
            <div
    class="inline-flex items-center justify-center w-14 h-14 rounded-2xl 
            bg-gradient-to-br from-red-600 to-red-800 
            shadow-lg shadow-red-900/30 mb-5"
    style="margin-left: auto !important; margin-right: auto !important; display: flex !important;">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2" dir="ltr">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-white mb-1.5 text-center">
                {{ __('admin_auth.welcome_back') }}
            </h1>
            <p class="text-sm text-gray-500 text-center">
                {{ __('admin_auth.subtitle') }}
            </p>
        </div>

        {{-- Card --}}
        <div class="relative bg-[#0f0f12] border border-white/[0.06] rounded-2xl p-6 shadow-2xl shadow-black/50">

            {{-- Thin red top bar --}}
            <div class="absolute top-0 left-6 right-6 h-px glow-line"></div>

            {{-- Account type badge --}}
            <div class="flex justify-center mb-6">
                <div
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md 
                            bg-red-950/40 border border-red-900/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span class="text-[10px] font-semibold text-red-300 tracking-wider uppercase">
                        {{ __('admin_auth.admin_access') }}
                    </span>
                </div>
            </div>

            @if (session('status'))
                <div
                    class="mb-5 p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/30 
                            text-emerald-300 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-400 mb-2">
                        {{ __('admin_auth.email') }}
                    </label>
                    <div class="relative" dir="ltr">
                        {{-- Email icon (left) --}}
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="admin@midad.com" required autofocus autocomplete="username"
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg
                                   bg-black/40 border border-white/[0.08]
                                   text-sm text-white placeholder-gray-600
                                   transition-all duration-200
                                   focus:outline-none focus:border-red-600/60 focus:bg-black/60
                                   focus:ring-1 focus:ring-red-600/30
                                   @error('email') border-red-600/60 @enderror">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="text-xs font-medium text-gray-400">
                            {{ __('admin_auth.password') }}
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-gray-500 hover:text-red-400 transition-colors">
                                {{ __('admin_auth.forgot') }}
                            </a>
                        @endif
                    </div>
                    <div class="relative" dir="ltr">
                        {{-- Lock icon (left) --}}
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>

                        {{-- Password field --}}
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            placeholder="••••••••" required autocomplete="current-password"
                            class="w-full pl-10 pr-11 py-2.5 rounded-lg
                   bg-black/40 border border-white/[0.08]
                   text-sm text-white placeholder-gray-600
                   transition-all duration-200
                   focus:outline-none focus:border-red-600/60 focus:bg-black/60
                   focus:ring-1 focus:ring-red-600/30
                   @error('password') border-red-600/60 @enderror">

                        {{-- Show/hide password button (right) --}}
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center
                       text-gray-600 hover:text-red-400 transition-colors
                       focus:outline-none">

                            {{-- Eye icon (open) --}}
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            {{-- Eye icon (crossed out) --}}
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Login button --}}
                <button type="submit"
                    class="w-full py-2.5 rounded-lg font-medium text-sm
                               bg-red-600 hover:bg-red-500
                               text-white
                               transition-all duration-200
                               shadow-lg shadow-red-900/30
                               focus:outline-none focus:ring-2 focus:ring-red-500/50">
                    {{ __('admin_auth.sign_in') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-white/[0.06]"></div>
                <span class="text-[10px] text-gray-600 uppercase tracking-wider">
                    {{ __('admin_auth.secure') }}
                </span>
                <div class="flex-1 h-px bg-white/[0.06]"></div>
            </div>

            {{-- Security notice --}}
            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>{{ __('admin_auth.security_notice') }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-[11px] text-gray-700 mt-6">
            {{ __('admin_auth.footer', ['year' => date('Y')]) }}
        </p>
    </div>
</body>

</html>