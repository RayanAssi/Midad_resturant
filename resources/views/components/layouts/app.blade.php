@props([
    'title' => 'Midad Restaurant',
])

<!DOCTYPE html>
<html lang="en" dir="ltr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Midad Restaurant</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-amber-50 antialiased
             bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))]
             from-red-950/30 via-black to-black">

    {{-- Top Navigation --}}
    <nav class="sticky top-0 z-50 backdrop-blur-md 
                bg-black/70 border-b-2 border-red-900/40
                shadow-lg shadow-red-950/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl 
                                bg-gradient-to-br from-red-600 to-red-800
                                flex items-center justify-center
                                shadow-lg shadow-red-900/50
                                group-hover:scale-110 transition-transform">
                        <span class="text-xl">🔥</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-black tracking-wider
                                   text-transparent bg-clip-text
                                   bg-gradient-to-r from-amber-300 via-orange-400 to-red-500">
                            MIDAD
                        </h1>
                        <p class="text-[10px] text-amber-200/50 uppercase tracking-widest">
                            Restaurant
                        </p>
                    </div>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('admin.menu-items.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-bold
                              text-amber-100/70 hover:text-amber-100
                              hover:bg-red-900/30 transition-all
                              {{ request()->routeIs('admin.*') ? 'bg-red-900/40 text-amber-100' : '' }}">
                        Admin
                    </a>
                    <a href="{{ route('cashier.menu-items.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-bold
                              text-amber-100/70 hover:text-amber-100
                              hover:bg-red-900/30 transition-all
                              {{ request()->routeIs('cashier.*') ? 'bg-red-900/40 text-amber-100' : '' }}">
                        Cashier
                    </a>
                </div>

                {{-- User --}}
                <div class="flex items-center gap-3">
                    <span class="hidden sm:block text-sm text-amber-200/70">
                        {{ auth()->user()->name ?? 'Guest' }}
                    </span>
                    <div class="w-9 h-9 rounded-full 
                                bg-gradient-to-br from-amber-500 to-red-700
                                flex items-center justify-center
                                text-white font-bold shadow-lg shadow-red-900/50">
                        {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                    </div>
                </div>

            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-16 border-t-2 border-red-900/40 bg-black/50">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p class="text-xs text-amber-200/40">
                © {{ date('Y') }} Midad Restaurant — All rights reserved
            </p>
        </div>
    </footer>

</body>
</html>