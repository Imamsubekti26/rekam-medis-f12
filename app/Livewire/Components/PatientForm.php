<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PatientForm extends Component
{
    public ?string $nik;
    public ?string $date_of_birth;
    public $is_male;

    public function handleNikChanged()
    {
        $parsedNik = parseNIK($this->nik);

        if ($parsedNik['error']) {
            $this->addError('nik', $parsedNik['error']);
            return;
        }

        $this->date_of_birth = $parsedNik['date_of_birth'];
        $this->is_male = (int) $parsedNik['is_male'];
    }

    public function render()
    {
        return view('livewire.components.patient-form');
    }
}
