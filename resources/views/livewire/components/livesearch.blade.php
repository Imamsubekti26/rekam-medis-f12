<div class="w-full relative">
    <flux:input wire:model="search_key" x-data="{holder:null}" x-on:keyup="clearTimeout(holder);holder=setTimeout(()=>{$wire.searchHandler()},100);" />
    @if ($dropdowns && count($dropdowns) > 0)
        <div class="bg-zinc-50 dark:bg-zinc-900 p-2 absolute z-50 rounded-xl mt-4 w-full left-0 border border-zinc-200 dark:border-zinc-700">
            <div class="max-h-36 overflow-y-auto text-left [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                @foreach ($dropdowns as $dropdown)
                    <p class="px-4 py-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-xl cursor-pointer" wire:click="dropdownSelected('{{ $dropdown['id'] }}')">{{ $dropdown['item'] }}</p>
                @endforeach
            </div>
        </div>
    @endif
</div>
