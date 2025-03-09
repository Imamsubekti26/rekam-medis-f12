<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class Livesearch extends Component
{
    public $search_key;
    public $dropdowns;

    #[On('dataObtained')]
    public function fillDropdown(array $dropdowns)
    {
        $this->dropdowns = $dropdowns;
    }

    public function dropdownSelected($id)
    {
        $this->search_key = array_filter($this->dropdowns, fn($d) => $d["id"] == $id)[0]['item'];
        $this->dropdowns = [];
        $this->dispatch('dropdownOnSelected', $id, $this->search_key);
    }

    public function searchHandler()
    {
        if (!$this->search_key) {
            $this->dropdowns = [];
            return;
        }
        
        $this->dispatch('dropdownOnSearch', $this->search_key);
    }

    public function mount($search_key = '')
    {
        $this->search_key = $search_key;
    }

    public function render()
    {
        return view('livewire.components.livesearch');
    }
}
