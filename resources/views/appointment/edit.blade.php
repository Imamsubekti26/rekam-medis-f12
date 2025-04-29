<x-layouts.app>
    <main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-12">
            {{-- Form Card --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-4 md:p-12">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
                        {{ __("appointment.title_update") }}
                    </h2>
                    <livewire:components.appointment-form :appointment="$appointment" />
                </div>
            </div>
            {{-- / Form Card --}}
        </div>
    </main>
</x-layouts.app>