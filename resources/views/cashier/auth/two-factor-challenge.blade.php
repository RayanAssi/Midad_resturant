<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Verification (Cashier) — Midad Restaurant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
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

        .code-input {
            text-align: center;
            font-size: 1.5rem;
            letter-spacing: 0.5em;
            font-weight: 600;
            font-family: 'IBM Plex Sans Arabic', monospace;
        }

        .code-input::placeholder {
            letter-spacing: 0.5em;
            font-weight: 400;
            color: rgba(107, 114, 128, 0.4);
        }
    </style>
</head>

<body class="min-h-screen bg-[#08080a] text-gray-200 flex items-center justify-center p-4 relative overflow-hidden">

    {{-- Grid background --}}
    <div class="absolute inset-0 grid-bg pointer-events-none"></div>

    {{-- Top glow --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] 
                bg-red-600/10 rounded-full blur-[100px] pointer-events-none">
    </div>

    {{-- Content --}}
    <div class="relative w-full max-w-[420px]" x-data="{ useRecoveryCode: false }">

        {{-- Logo + Title --}}
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

            <h1 class="text-2xl font-bold text-white mb-1.5">
                Two-Factor Verification
            </h1>
            <p class="text-sm text-gray-500">
                Enter the 6-digit code from your authenticator app
            </p>
        </div>

        {{-- Card --}}
        <div class="relative bg-[#0f0f12] border border-white/[0.06] rounded-2xl p-6 shadow-2xl shadow-black/50">

            {{-- Top glow line --}}
            <div class="absolute top-0 left-6 right-6 h-px glow-line"></div>

            {{-- Badge --}}
            <div class="flex justify-center mb-6">
                <div
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md 
                            bg-red-950/40 border border-red-900/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span class="text-[10px] font-semibold text-red-300 tracking-wider uppercase">
                        Cashier 2FA
                    </span>
                </div>
            </div>

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

            <form method="POST" action="{{ url()->current() }}" class="space-y-5">
                @csrf

                {{-- Code input --}}
                <div x-show="!useRecoveryCode">
                    <label for="code" class="block text-xs font-medium text-gray-400 mb-2">
                        Verification Code
                    </label>
                    <div class="relative">
                        <input type="text" id="code" name="code" maxlength="6" inputmode="numeric"
                            pattern="[0-9]*" autocomplete="one-time-code" autofocus
                            placeholder="------"
                            oninput="if(this.value.length === 6) this.form.submit();"
                            class="code-input w-full py-3 rounded-lg
                                   bg-black/40 border border-white/[0.08]
                                   text-white placeholder-gray-600
                                   transition-all duration-200
                                   focus:outline-none focus:border-red-600/60 focus:bg-black/60
                                   focus:ring-1 focus:ring-red-600/30
                                   @error('code') border-red-600/60 @enderror">
                    </div>
                </div>

                {{-- Recovery Code input --}}
                <div x-show="useRecoveryCode" x-cloak>
                    <label for="recovery_code" class="block text-xs font-medium text-gray-400 mb-2">
                        Recovery Code
                    </label>
                    <div class="relative">
                        <input type="text" id="recovery_code" name="recovery_code"
                            placeholder="xxxx-xxxx" autocomplete="off"
                            class="w-full px-4 py-2.5 rounded-lg
                                   bg-black/40 border border-white/[0.08]
                                   text-sm text-white placeholder-gray-600
                                   font-mono tracking-wider
                                   transition-all duration-200
                                   focus:outline-none focus:border-red-600/60 focus:bg-black/60
                                   focus:ring-1 focus:ring-red-600/30
                                   @error('recovery_code') border-red-600/60 @enderror">
                    </div>
                    <p class="mt-2 text-[11px] text-gray-600">
                        Use one of the recovery codes you saved when enabling 2FA.
                    </p>
                </div>

                {{-- Verify button --}}
                <button type="submit"
                    class="w-full py-2.5 rounded-lg font-medium text-sm
                           bg-red-600 hover:bg-red-500
                           text-white
                           transition-all duration-200
                           shadow-lg shadow-red-900/30
                           focus:outline-none focus:ring-2 focus:ring-red-500/50">
                    <span x-show="!useRecoveryCode">Verify & Sign In</span>
                    <span x-show="useRecoveryCode" x-cloak>Use Recovery Code</span>
                </button>
            </form>

            {{-- Toggle --}}
            <div class="mt-5 text-center">
                <button type="button" @click="useRecoveryCode = !useRecoveryCode"
                    class="text-xs text-gray-500 hover:text-red-400 transition-colors">
                    <span x-show="!useRecoveryCode">
                        No access to your app? Use a recovery code →
                    </span>
                    <span x-show="useRecoveryCode" x-cloak>
                        ← Back to app code
                    </span>
                </button>
            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-white/[0.06]"></div>
                <span class="text-[10px] text-gray-600 uppercase tracking-wider">Secure</span>
                <div class="flex-1 h-px bg-white/[0.06]"></div>
            </div>

            {{-- Security note --}}
            <div class="flex items-center gap-2 text-[11px] text-gray-600">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Encrypted connection • Two-factor authentication enabled</span>
            </div>
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ url('/cashier/logout') }}" class="mt-4 text-center">
            @csrf
            <button type="submit" class="text-[11px] text-gray-600 hover:text-red-400 transition-colors">
                ← Sign out and return to login
            </button>
        </form>

        {{-- Footer --}}
        <p class="text-center text-[11px] text-gray-700 mt-6">
            © {{ date('Y') }} Midad Restaurant — All rights reserved
        </p>
    </div>
</body>

</html>