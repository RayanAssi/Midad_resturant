@props([])

<header
    class="sticky top-0 z-30 
               bg-black/80 backdrop-blur-md
               border-b-2 border-red-900/40
               shadow-lg shadow-red-950/20">

    <div class="flex items-center justify-between h-17 px-6 gap-4">

        {{-- Breadcrumb --}}
        <x-breadcrumb />

        {{-- Right Side --}}
        <div class="flex items-center gap-4 flex-shrink-0">
            <x-user-dropdown :profile-route="route('admin.profile.show')" />
        </div>
    </div>
</header>
