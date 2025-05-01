<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumbs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $list = [
            'dashboard' => [
                [
                    "label" => __('dashboard.dashboard'),
                    "link" => route('dashboard')
                ]
            ],
            'record.index' => [
                [
                    "label" => __('dashboard.medical_record'),
                    "link" => route('record.index')
                ]
            ],
            'patient.index' => [
                [
                    "label" => __('dashboard.patient'),
                    "link" => route('patient.index')
                ]
            ],
            'doctor.index' => [
                [
                    "label" => __('dashboard.doctor'),
                    "link" => route('doctor.index')
                ]
            ],
            'pharmacist.index' => [
                [
                    "label" => __('dashboard.pharmacist'),
                    "link" => route('pharmacist.index')
                ]
            ],
            'medicine.index' => [
                [
                    "label" => __('dashboard.medicine'),
                    "link" => route('medicine.index')
                ]
            ],
            'schedule.index' => [
                [
                    "label" => __('dashboard.schedule'),
                    "link" => route('schedule.index')
                ]
            ],
            'appointment.index' => [
                [
                    "label" => __('dashboard.appointment'),
                    "link" => route('appointment.index')
                ]
            ]
        ];
        return view('components.bread-crumbs', compact('list'));
    }
}
