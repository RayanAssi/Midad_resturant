<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Employee' }}</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23dc2626'/%3E%3Cg transform='translate(4,4)' fill='none' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z'/%3E%3Cpath d='M6 17h12'/%3E%3C/g%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-950 via-black to-gray-900 text-amber-100">

    {{-- Navbar --}}
    <x-employee.navbar />

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-6 pt-6">
        <x-breadcrumb />
    </div>

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-6 py-6">
           <x-flash-message />
        {{ $slot }}
    </main>
    <x-logout-modal />
</body>

</html>
