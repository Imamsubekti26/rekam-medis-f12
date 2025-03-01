<x-layouts.app.sidebar>
    <flux:main>
        {{ $slot }}
    </flux:main>

    @if (session('errors'))
        <livewire:components.notification :variant="'errors'" :message="session('errors')" />
    @elseif (session('success'))
        <livewire:components.notification :variant="'success'" :message="session('success')" />
    @endif

</x-layouts.app.sidebar>
