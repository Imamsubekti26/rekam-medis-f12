<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Notification extends Component
{
    public $showNotification = true;
    public $variant;
    public $message;

    public function closeNotification()
    {
        $this->showNotification = false;
    }

    public function mount(string $variant = "success", string $message = "")
    {
        $this->variant = $variant;
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.components.notification');
    }
}
