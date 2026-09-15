@php
    $flash = null;

    if (session('success')) {
        $flash = ['type' => 'success', 'message' => session('success')];
    } elseif (session('error')) {
        $flash = ['type' => 'error', 'message' => session('error')];
    } elseif (session('warning')) {
        $flash = ['type' => 'warning', 'message' => session('warning')];
    } elseif (session('info')) {
        $flash = ['type' => 'info', 'message' => session('info')];
    }

    $colors = [
        'success' => 'bg-green-950/60 border-green-800/50 text-green-100',
        'error' => 'bg-red-950/60 border-red-800/50 text-red-100',
        'warning' => 'bg-amber-950/60 border-amber-800/50 text-amber-100',
        'info' => 'bg-blue-950/60 border-blue-800/50 text-blue-100',
    ];
@endphp

@if ($flash)
    <div id="flash-message"
        class="fixed top-6 left-1/2 -translate-x-1/2 z-50
                w-full max-w-lg mx-auto px-5 py-3.5 rounded-xl
                backdrop-blur-sm border-2
                flex items-center justify-between gap-4
                shadow-2xl shadow-black/50
                transition-opacity duration-500
                {{ $colors[$flash['type']] }}">

        <p class="flex-1 font-medium text-sm">{{ $flash['message'] }}</p>

        <button type="button" onclick="closeFlash()"
            class="flex-shrink-0 w-6 h-6 rounded
                    hover:bg-white/10 transition-colors
                    flex items-center justify-center
                    text-current opacity-60 hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <script>
        function closeFlash() {
            const el = document.getElementById('flash-message');
            if (!el) return;
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }

        setTimeout(closeFlash, 4000);
    </script>
@endif
