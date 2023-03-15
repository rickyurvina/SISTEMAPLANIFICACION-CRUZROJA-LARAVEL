<?php

namespace App\Http\Livewire\Strategy;

use Livewire\Component;

class StrategyReportArticulations extends Component
{

    public function mount(){

    }

    public function render()
    {
        $articulations=\App\Models\Strategy\PlanArticulations::get();
        return view('livewire.strategy.strategy-report-articulations', compact('articulations'));
    }
}
