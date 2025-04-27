<flux:breadcrumbs
    class="mb-4 px-3 py-1 rounded-2xl bg-gradient-to-r from-blue-200 via-blue-100 to-blue-100
           dark:from-custom-50 dark:via-purple-700 dark:to-purple-600
           shadow-[0_4px_15px_rgba(103,49,191,0.4)] dark:shadow-[0_4px_15px_rgba(103,49,191,0.6)] transition-shadow duration-300">

    <flux:breadcrumbs.item href="{{ route('dashboard') }}">
        <flux:icon.home class="size-4" />
    </flux:breadcrumbs.item>
    @foreach ($list[Route::currentRouteName()] as $item)
        <flux:breadcrumbs.item href="{{ $item['link'] }}">
            {{ $item['label'] }}
        </flux:breadcrumbs.item>
    @endforeach
</flux:breadcrumbs>
