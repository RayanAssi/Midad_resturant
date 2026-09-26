@props([
    'title' => 'Dashboard',
])

@php
    $navItems = config('navigation.admin', []);
@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    {{-- ✅ Favicon --}}
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23dc2626'/%3E%3Cg transform='translate(4,4)' fill='none' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z'/%3E%3Cpath d='M6 17h12'/%3E%3C/g%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/css/intlTelInput.css">
</head>

<body
    class="min-h-screen bg-black text-amber-50 antialiased
             bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))]
             from-red-950/20 via-black to-black">

    {{-- Sidebar --}}
    <x-sidebar :items="$navItems" />

    {{-- Main Content --}}
    <div class="ml-64 flex flex-col min-h-screen">

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
    <x-logout-modal />

    @stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@29.2.3/dist/js/intlTelInput.min.js"></script>
</body>
</html>
