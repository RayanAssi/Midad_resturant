@props([
    'action',
    'method' => 'POST',
    'title' => 'Confirm Password',
    'description' => 'Please confirm your password to continue.',
    'badge' => 'Secure',
    'logoutUrl' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Midad Restaurant</title>

    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23dc2626'/%3E%3Cg transform='translate(4,4)' fill='none' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z'/%3E%3Cpath d='M6 17h12'/%3E%3C/g%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', system-ui, -apple-system, sans-serif;
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

    {{-- Grid background --}}
    <div class="absolute inset-0 grid-bg pointer-events-none"></div>

    {{-- Top glow --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px]
                bg-red-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative w-full max-w-[420px]">

        {{-- Logo + Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl
                        bg-gradient-to-br from-red-600 to-red-800
                        shadow-lg shadow-red-900/30 mb-5">
                <x-lucide-shield-check class="w-7 h-7 text-white" />
            </div>

            <h1 class="text-2xl font-bold text-white mb-1.5">
                {{ $title }}
            </h1>
            <p class="text-sm text-gray-500">
                {{ $description }}
            </p>
        </div>

        {{-- Card --}}
        <div class="relative bg-[#0f0f12] border border-white/[0.06] rounded-2xl p-6 shadow-2xl shadow-black/50">

            {{-- Top glow line --}}
            <div class="absolute top-0 left-6 right-6 h-px glow-line"></div>

            {{-- Badge --}}
            @if ($badge)
                <div class="flex justify-center mb-6">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                                bg-red-950/40 border border-red-900/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-[10px] font-semibold text-red-300 tracking-wider uppercase">
                            {{ $badge }}
                        </span>
                    </div>
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-5 p-3 rounded-lg bg-red-500/10 border border-red-500/30
                            text-red-300 text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $action }}" class="space-y-5">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                <div>
                    <label for="password" class="block text-xs font-medium text-gray-400 mb-2">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required autofocus
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        class="w-full px-4 py-2.5 rounded-lg
                               bg-black/40 border border-white/[0.08]
                               text-sm text-white placeholder-gray-600
                               transition-all duration-200
                               focus:outline-none focus:border-red-600/60 focus:bg-black/60
                               focus:ring-1 focus:ring-red-600/30
                               @error('password') border-red-600/60 @enderror">
                    @error('password')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg font-medium text-sm
                           bg-red-600 hover:bg-red-500
                           text-white
                           transition-all duration-200
                           shadow-lg shadow-red-900/30
                           focus:outline-none focus:ring-2 focus:ring-red-500/50">
                    Confirm
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-white/[0.06]"></div>
                <span class="text-[10px] text-gray-600 uppercase tracking-wider">Secure</span>
                <div class="flex-1 h-px bg-white/[0.06]"></div>
            </div>

            {{-- Security note --}}
            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                <x-lucide-lock class="w-3.5 h-3.5 flex-shrink-0" />
                <span>Encrypted connection • Two-factor authentication</span>
            </div>
        </div>

        {{-- Logout --}}
        @if ($logoutUrl)
            <form method="POST" action="{{ $logoutUrl }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-[11px] text-gray-600 hover:text-red-400 transition-colors">
                    ← Sign out and return to login
                </button>
            </form>
        @endif

        {{-- Footer --}}
        <p class="text-center text-[11px] text-gray-700 mt-6">
            © {{ date('Y') }} Midad Restaurant — All rights reserved
        </p>
    </div>
</body>

</html>