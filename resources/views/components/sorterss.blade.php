<?php

use Livewire\Volt\Component;

new class extends Component {
    public $stat = 'name_asc';
}; ?>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="size-6">
    @if ($stat == 'name_asc')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />        
    @else
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 8.25-7.5 7.5-7.5-7.5" />        
    @endif
</svg>
