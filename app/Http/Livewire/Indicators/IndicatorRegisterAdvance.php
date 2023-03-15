<?php

namespace App\Http\Livewire\Indicators;

use App\Http\Livewire\Components\Modal;
use App\Models\Indicators\GoalIndicator\GoalIndicators;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Indicator\IndicatorParentChild;
use App\Models\Indicators\Units\IndicatorUnits;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class IndicatorRegisterAdvance extends Modal
{
    public Indicator $indicator;
    protected $listeners =
        [
            'actionLoad' => 'registerAdvance'
        ];

    public function render()
    {
        return view('livewire.indicators.indicator-register-advance');
    }

    public function registerAdvance($id)
    {
        $this->indicator = Indicator::with(['indicatorGoals'])->find($id);
    }

    public function resetFields()
    {
        $this->emit('indicatorUpdated');
        $this->emit('loadIndicatorUpdated');
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
