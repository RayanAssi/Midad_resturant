@if (session('flashMessage'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mb-6 p-4 rounded-xl 
               bg-gradient-to-r from-green-900/80 to-green-800/60
               border-r-4 border-amber-400
               text-amber-50 shadow-lg shadow-green-900/50
               flex items-center gap-3 backdrop-blur-sm"
    >
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 
                    flex items-center justify-center">
            <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <span class="font-semibold">{{ session('flashMessage') }}</span>
        <button @click="show = false" class="mr-auto text-amber-200 hover:text-white transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 4000)"
        x-transition
        class="mb-6 p-4 rounded-xl 
               bg-gradient-to-r from-red-900/80 to-red-800/60
               border-r-4 border-amber-400
               text-amber-50 shadow-lg shadow-red-900/50
               flex items-center gap-3 backdrop-blur-sm"
    >
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-red-700 
                    flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
        <span class="font-semibold">{{ session('error') }}</span>
        <button @click="show = false" class="mr-auto text-amber-200 hover:text-white transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
@endif