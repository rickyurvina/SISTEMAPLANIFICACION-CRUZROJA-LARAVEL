<?php

namespace App\Http\Livewire\Measure;

use App\Http\Livewire\Components\Modal;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Period;
use App\Models\Measure\ScoringType;

class MeasureShow extends Modal
{
    public $measure = null;
    public $periodId = null;
    public $period = null;
    public $scores = [];
    public $score = null;
    public $currentScore = null;
    public $beforeScore = null;
    public $type = null;
    public $elementTreeName = null;

    public $difScore = [
        'value' => '',
        'color' => ''
    ];

    public function show(...$arg)
    {
        if (is_int($arg[0])) {
            $this->measure = Measure::find($arg[0]);
            $this->measure->load([
                'scores',
                'unit',
                'responsible',
                'calendar.periods',
                'scoringType',
            ]);
            $this->init();
        }
    }

    public function mount(int $periodId=null)
    {
        if ($periodId) {
            $this->periodId = $periodId;

        } else {
            $period = Period::where([
                ['start_date', '<=', now()->format('Y-m-d')],
                ['end_date', '>=', now()->format('Y-m-d')],
            ])->whereRelation('calendar', 'frequency', Calendar::FREQUENCY_MONTHLY)->first();
            $this->periodId = $period->id;
        }
    }

    public function init()
    {
        $this->score = $this->measure->score($this->periodId);
        $this->period = Period::find($this->periodId);
        $periods = Period::query()->where('calendar_id', $this->period->calendar_id)
            ->orderBy('start_date', 'desc')
            ->whereDate('start_date', '<=', $this->period->start_date)
            ->take(12)
            ->get();

        $this->scores = collect([]);

        foreach ($periods->reverse() as $value) {
            $this->scores->push($this->measure->score($value->id));
        }
        $this->currentScore = $this->scores->firstWhere('period_id', $this->periodId);
        $this->beforeScore = $this->scores->get($this->scores->count() - 2);

        if ($this->currentScore && $this->beforeScore) {
            if ($this->currentScore['score'] - $this->beforeScore['score'] >= 0) {
                $this->difScore = [
                    'value' => '+' . round($this->currentScore['score'] - $this->beforeScore['score'], 1),
                    'color' => '#96cd00'
                ];
            } else {
                $this->difScore = [
                    'value' => round($this->currentScore['score'] - $this->beforeScore['score'], 1),
                    'color' => '#f25131'
                ];
            }
        } else {
            $this->difScore = [
                'value' => '+0',
                'color' => '#96cd00'
            ];
        }
        if (!$this->currentScore) {
            $this->dispatchBrowserEvent('updateData',
                [
                    'historicalScore' => [],
                    'score' => null,
                    'red' => '',
                    'goal' => '',
                    'performance' => '',
                    'difPerformance' => '',
                    'difPerformanceColor' => '',
                ]
            );
        } else {
            switch ($this->measure->scoringType->code) {
                case(ScoringType::TYPE_GOAL_RED_FLAG):
                    $this->dispatchBrowserEvent('updateData',
                        [
                            'historicalScore' => $this->scores,
                            'score' => $this->currentScore['score'],
                            'red' => $this->currentScore['thresholds'][1],
                            'goal' => $this->currentScore['thresholds'][2],
                            'performance' => $this->currentScore['value'],
                            'difPerformance' => $this->difScore['value'],
                            'difPerformanceColor' => $this->difScore['color'],
                        ]
                    );
                    break;
                case(ScoringType::TYPE_THREE_COLORS):
                    $this->dispatchBrowserEvent('updateData',
                        [
                            'historicalScore' => $this->scores,
                            'score' => $this->currentScore['score'],
                            'red' => $this->currentScore['thresholds'][2],
                            'goal' => $this->currentScore['thresholds'][3],
                            'performance' => $this->currentScore['value'],
                            'difPerformance' => $this->difScore['value'],
                            'difPerformanceColor' => $this->difScore['color'],
                        ]
                    );
                    break;
            }
        }

    }

    public function render()
    {
        return view('livewire.measure.measure-show');
    }
}
