<flux:breadcrumbs class="mb-4 opacity-50">
    <flux:breadcrumbs.item href="{{ route('dashboard') }}">
        <flux:icon.home class="size-4" />
    </flux:breadcrumbs.item>
    @foreach ($list[Route::currentRouteName()] as $item)
        <flux:breadcrumbs.item href="{{ $item['link'] }}">
            {{ $item['label'] }}
        </flux:breadcrumbs.item>
    @endforeach
</flux:breadcrumbs>