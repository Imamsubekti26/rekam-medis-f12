<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Sorter extends Component
{
    public $asc;
    public $desc;
    private $current_url;
    public $current_sort;
    private $current_search;
    private $current_page;
    public $target_url;

    private function setTartgetUrl()
    {
        $query_string = "?";
        
        if ($this->current_search != '') {
            $query_string .= 'search='. $this->current_search . "&";
        }

        $query_string .= match ($this->current_sort) {
            $this->asc => "sort_by=" . $this->desc,
            $this->desc => "sort_by=" . $this->asc,
            default => "sort_by=" . $this->asc,
        };

        if ($this->current_page != '') {
            $query_string .= '&page='. $this->current_page;
        }

        $this->target_url = $this->current_url . $query_string;
    }
    
    public function mount($asc, $desc)
    {
        $this->asc = $asc;
        $this->desc = $desc;

        $this->current_url = request()->url();
        $this->current_sort = request()->query('sort_by');
        $this->current_search = request()->query('search');
        $this->current_page = request()->query('page');

        $this->setTartgetUrl();
    }
    public function render()
    {
        return view('livewire.components.sorter');
    }
}
