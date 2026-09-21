@props([
    'action' => '#',
    'method' => 'POST',
    'title' => 'Confirm Password',
    'description' => 'This is a secure area. Please confirm your password before continuing.',
    'badge' => 'Secure Verification',
    'logoutUrl' => '#',
])

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Midad Restaurant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'IBM Plex Sans Arabic', sans-serif; }
        .grid-bg {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .glow-line { background: linear-gradient(90deg, transparent, #dc2626, transparent); }
    </style>
</head>

<body class="min-h-screen bg-[#08080a] text-gray-200 flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute inset-0 grid-bg pointer-events-none"></div>
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] 
                bg-red-600/10 rounded-full blur-[100px] pointer-events-none">
    </div>

    <div class="relative w-full max-w-[420px]">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl 
                        bg-gradient-to-br from-red-600 to-red-800 
                        shadow-lg shadow-red-900/30 mb-5">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-white mb-1.5">{{ $title }}</h1>
            <p class="text-sm text-gray-500">{{ $description }}</p>
        </div>

        <div class="relative bg-[#0f0f12] border border-white/[0.06] rounded-2xl p-6 shadow-2xl shadow-black/50">

            <div class="absolute top-0 left-6 right-6 h-px glow-line"></div>

            <div class="flex justify-center mb-6">
                <div
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md 
                            bg-red-950/40 border border-red-900/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span class="text-[10px] font-semibold text-red-300 tracking-wider uppercase">
                        {{ $badge }}
                    </span>
                </div>
            </div>

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
                @method($method)

                <div>
                    <label for="password" class="block text-xs font-medium text-gray-400 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            placeholder="••••••••" required autofocus autocomplete="current-password"
                            class="w-full px-4 py-2.5 rounded-lg
                                   bg-black/40 border border-white/[0.08]
                                   text-sm text-white placeholder-gray-600
                                   transition-all duration-200
                                   focus:outline-none focus:border-red-600/60 focus:bg-black/60
                                   focus:ring-1 focus:ring-red-600/30
                                   @error('password') border-red-600/60 @enderror">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg font-medium text-sm
                           bg-red-600 hover:bg-red-500
                           text-white
                           transition-all duration-200
                           shadow-lg shadow-red-900/30
                           focus:outline-none focus:ring-2 focus:ring-red-500/50">
                    Confirm & Continue
                </button>
            </form>

            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-white/[0.06]"></div>
                <span class="text-[10px] text-gray-600 uppercase tracking-wider">Secure</span>
                <div class="flex-1 h-px bg-white/[0.06]"></div>
            </div>

            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Encrypted connection • Verification required</span>
            </div>
        </div>

        <form method="POST" action="{{ $logoutUrl }}" class="mt-4 text-center">
            @csrf
            <button type="submit" class="text-[11px] text-gray-600 hover:text-red-400 transition-colors">
                ← Cancel and sign out
            </button>
        </form>

        <p class="text-center text-[11px] text-gray-700 mt-6">
            © {{ date('Y') }} Midad Restaurant — All rights reserved
        </p>
    </div>
</body>

</html>