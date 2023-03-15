<?php

namespace App\Http\Livewire\Measure;

use App\Models\Measure\Calendar;
use Illuminate\Support\Collection;
use Livewire\Component;

class FilterPeriods extends Component
{

    public ?Collection $calendars = null;

    public $currentPeriodId = null;

    public function mount($periodId)
    {
        $this->calendars = Calendar::with(['periods.children', 'periods.parents'])->orderBy('id')->get();
        $this->currentPeriodId = $periodId;
        $this->showResults($this->currentPeriodId);
    }

    public function showResults($periodId)
    {
        session(['periodId' => $periodId]);
        $this->emit('period-changed', $periodId);
    }

    public function render()
    {
        return view('livewire.measure.filter-periods');
    }
}
