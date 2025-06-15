<x-layouts.basic>
    {{-- Mode Gelap/Terang --}}
    <div class="absolute right-0 top-0 mt-4 mr-4 z-50">
        <flux:menu.radio.group x-data x-model="$flux.appearance" variant="segmented"
            class="flex cursor-pointer bg-gray-400 dark:bg-gray-600/50 rounded-xl p-2 shadow-lg">
            <flux:radio value="light" icon="sun" class="py-1 cursor-pointer" />
            <flux:radio value="dark" icon="moon" class="py-1 cursor-pointer" />
        </flux:menu.radio.group>
    </div>

    {{-- Tombol Kembali --}}
    <div class="absolute left-0 top-0 mt-4 ml-4 z-50">
        <a href="/" wire:navigate
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-xl transition dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 text-sm sm:text-base">
            ← Kembali
        </a>
    </div>
    <div class="w-full pt-10 sm:pt-0 md:pt-0">
        <div class="mb-5 px-4 pt-2 md:px-0">
            <div class="bg-yellow-100 text-yellow-800 dark:bg-yellow-300/20 dark:text-yellow-200 border-l-4 border-yellow-400 p-4 rounded-md text-sm md:text-base text-center max-w-2xl mx-auto">
                📅 Silakan klik pada jadwal atau nama dokter di kalender untuk melakukan janji temu.
            </div>
        </div>
        <livewire:components.calendar />
    </div>
</x-layouts.basic>