<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Cashier' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-950 via-black to-gray-900 text-amber-100">

    {{-- Navbar --}}
    <x-cashier.navbar />

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-6 pt-6">
        <x-breadcrumb />
    </div>

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-6 py-6">
        {{ $slot }}
    </main>

</body>
</html>