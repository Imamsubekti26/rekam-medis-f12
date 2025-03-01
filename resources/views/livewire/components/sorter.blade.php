<a href="{{ $target_url }}" wire:navigate>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-6 cursor-pointer">
        @if ($current_sort == $asc)
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 9 12 5.25 15.75 9" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8.25 15 12 18.75 15.75 15" />
        @elseif ($current_sort == $desc)
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8.25 9 12 5.25 15.75 9" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 15 12 18.75 15.75 15" />
        @else
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8.25 9 12 5.25 15.75 9" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8.25 15 12 18.75 15.75 15" />
        @endif
    </svg>
</a>