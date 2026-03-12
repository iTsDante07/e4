@aware(['class' => ''])

<a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group {{ $class }}">
    <!-- Zwaard icoon -->
    <div class="relative">
        <svg class="h-9 w-9 text-indigo-600 group-hover:text-indigo-800 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v18m0 0l-4-4m4 4l4-4M5 5l14 14M5 19L19 5"></path>
        </svg>

        <!-- Glow effect voor het zwaard -->
        <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <span class="absolute inset-0 bg-indigo-400 blur-md rounded-full"></span>
        </span>
    </div>

    <!-- Tekst -->
    <span class="font-bold text-xl text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 transition-colors duration-200">
        DreamScape
    </span>
</a>
