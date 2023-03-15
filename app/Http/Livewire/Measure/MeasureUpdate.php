<?php

namespace App\Http\Livewire\Measure;

use App\Models\Measure\Measure;
use App\Models\Measure\Score;
use Illuminate\Support\Collection;
use Livewire\Component;

class MeasureUpdate extends Component
{

    public ?Collection $scores = null;

    public array $thresholds = [];

    public $periodId = null;

    protected $rules = [
        'scores.*.thresholds.*' => 'required|numeric',
    ];

    protected $listeners = ['period-changed' => 'updatePeriod'];

    public function mount($periodId)
    {
        $this->periodId = $periodId;
        $this->scores = Score::where([
            ['scoreable_type', '=', Measure::class],
            ['period_id', '=', $this->periodId]
        ])->with(['scoreable', 'period'])->get();

        $this->scores->map(function ($sc) {
            $this->thresholds[$sc->id] = $sc->thresholds;
        });
    }

    public function updatePeriod($id)
    {
        $this->periodId = $id;
        $this->scores = Score::where([
            ['scoreable_type', '=', Measure::class],
            ['period_id', '=', $this->periodId]
        ])->with(['scoreable', 'period'])->get();

        $this->thresholds = [];
        $this->scores->map(function ($sc) {
            $this->thresholds[$sc->id] = $sc->thresholds;
        });
    }

    public function save()
    {
        $this->validate();
        foreach ($this->scores as $score) {
            $score->thresholds = $this->thresholds[$score->id];
            $score->save();
        }

        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.indicators', 1)]))->success()->livewire($this);
    }

    public function render()
    {
        return view('livewire.measure.measure-update');
    }
}
