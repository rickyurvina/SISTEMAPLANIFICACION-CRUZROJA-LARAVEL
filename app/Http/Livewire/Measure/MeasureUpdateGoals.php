<?php

namespace App\Http\Livewire\Measure;

use App\Http\Livewire\Components\Modal;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Score;
use App\Models\Measure\ScoringType;
use Illuminate\Support\Collection;
use DateTime;

class MeasureUpdateGoals extends Modal
{
    public $measure, $data = [];

    public ?Collection $calendars = null, $scoring = null, $scores=null;

    public array $thresholds = [];

    protected $rules = [
        'scores.*.thresholds.*' => 'required|numeric',
    ];

    public function show(...$arg)
    {
        if (is_int($arg[0])) {
            $this->measure = Measure::with(['scores.period.calendar'])->find($arg[0]);
            parent::show();;
            $this->scores = Score::where([
                ['scoreable_type', '=', Measure::class],
                ['scoreable_id', '=', $this->measure->id]
            ])->with(['scoreable', 'period'])->orderBy('id')->get();
            self::init();
        }
    }

    public function render()
    {
        return view('livewire.measure.measure-update-goals');
    }

    public function init()
    {
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
}
