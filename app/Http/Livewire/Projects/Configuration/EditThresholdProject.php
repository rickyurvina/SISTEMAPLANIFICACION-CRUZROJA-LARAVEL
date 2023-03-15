<?php

namespace App\Http\Livewire\Projects\Configuration;

use App\Models\Projects\Configuration\ProjectThreshold;
use Livewire\Component;

class EditThresholdProject extends Component
{
    public $threshold;
    public $timeMin;
    public $timeMax;
    public $progressMin;
    public $progressMax;

    protected $listeners = ['openEditThreshold'];

    protected $rules=
        [
            'timeMin'=>'min:0|lt:timeMax',
            'timeMax'=>'max:100|gt:timeMin',
            'progressMin'=>'min:00|lt:progressMax',
            'progressMax'=>'max:100|gt:progressMin'
        ];

    protected $messages=
        [
            'timeMin.lt'=>'El tiempo mínimo debe ser menor que el tiempo máximo',
            'timeMax.gt'=>'El tiempo máximo debe ser mayor que el tiempo mínimo',
            'progressMin.lt'=>'El progreso mínimo debe ser menor que el progreso máximo',
            'progressMax.gt'=>'El progreso máximo debe ser mayor que el progreso mínimo',
        ];

    public function openEditThreshold(int $id)
    {
        $this->threshold = ProjectThreshold::find($id);
        $this->timeMin = $this->threshold->properties['time']['min'];
        $this->timeMax = $this->threshold->properties['time']['max'];
        $this->progressMin = $this->threshold->properties['progress']['min'];
        $this->progressMax = $this->threshold->properties['progress']['max'];

    }

    public function render()
    {
        return view('livewire.projects.configuration.edit-threshold-project');
    }

    public function edit()
    {
        $this->validate();
        $properties =
            [
                'time' =>
                    [
                        'min' => $this->timeMin,
                        'max' => $this->timeMax,
                    ],
                'progress' =>
                    [
                        'min' => $this->progressMin,
                        'max' => $this->progressMax
                    ],
            ];
        $this->threshold->properties = $properties;
        $this->threshold->save();
        $this->emit('refreshIndexThresholds');
        $this->reset(
            [
                'timeMin',
                'timeMax',
                'progressMin',
                'progressMax',
                'threshold',
            ]);
        $this->emit('toggleEditThreshold');

    }

    public function closeModal()
    {
        $this->reset(
            [
                'timeMin',
                'timeMax',
                'progressMin',
                'progressMax',
                'threshold',
            ]);
    }
}
