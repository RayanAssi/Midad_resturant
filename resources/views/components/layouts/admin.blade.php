@props([
    'title' => 'Dashboard',
])

@php
    $navItems = config('navigation.admin', []);
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Midad Restaurant</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-amber-50 antialiased
             bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))]
             from-red-950/20 via-black to-black">

    {{-- Sidebar --}}
    <x-sidebar :items="$navItems" />

    {{-- Main Content --}}
    <div class="mr-64 flex flex-col min-h-screen">

        {{-- Topbar --}}
        <x-topbar :title="$title" />

        {{-- Flash Message --}}
        <x-flash-message />

        {{-- Page Content --}}
        <main class="flex-1 px-8 py-8">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t-2 border-red-900/40 bg-black/50">
            <div class="px-8 py-4 text-center">
                <p class="text-xs text-amber-200/40">
                    © {{ date('Y') }} Midad Restaurant — All rights reserved
                </p>
            </div>
        </footer>
    </div>

</body>
</html>