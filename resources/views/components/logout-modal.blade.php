@php
    if (auth('admin')->check()) {
        $logoutUrl = '/admin/logout';
    } else {
        $logoutUrl = '/cashier/logout';
    }

    $accentClass = 'bg-gradient-to-r from-red-700 to-red-900 hover:from-red-600 hover:to-red-800 shadow-red-900/50';
    $borderClass = 'border-red-900/50';
    $iconClass = 'bg-red-900/30 border-red-700/50 text-red-400';
@endphp

<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border-2 {{ $borderClass }} rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl">

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full border {{ $iconClass }} mb-3">
                <x-lucide-log-out class="w-6 h-6" />
            </div>
            <h3 class="text-lg font-bold text-amber-100 mb-1">Confirm Logout</h3>
            <p class="text-sm text-gray-400">Are you sure you want to log out?</p>
        </div>

        <form id="logoutForm" method="POST" action="{{ $logoutUrl }}">
            @csrf
        </form>

        <div class="flex gap-3">
            <button type="button" onclick="closeLogoutModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl font-bold bg-gray-800 text-gray-300 border border-gray-700 hover:bg-gray-700 transition-all duration-200">
                Cancel
            </button>
            <button type="button" onclick="document.getElementById('logoutForm').submit()"
                    class="flex-1 px-4 py-2.5 rounded-xl font-bold text-white border border-amber-500/20 transition-all duration-200 shadow-lg {{ $accentClass }}">
                Yes, Log Out
            </button>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLogoutModal();
    });
    document.getElementById('logoutModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'logoutModal') closeLogoutModal();
    });
</script>