<?php

namespace App\Http\Livewire\Strategy;

use App\Models\Measure\Measure;
use App\Models\Measure\Period;
use App\Models\Measure\ScoringType;
use App\Models\Strategy\PlanDetail;
use Livewire\Component;

class Dashboard extends Component
{

    public $currentScore = null;

    public $beforeScore = null;

    public $difScore = [
        'value' => '',
        'color' => ''
    ];

    public $scores = [];

    public $model = null;

    public $type = null;

    public $elementTreeName = null;

    protected $listeners = ['period-changed' => 'updatePeriod'];

    public function mount($periodId, $model, $type)
    {
        $this->model = $model;
        if (isset($model->children) && $model->children->count() > 0) {
            $this->elementTreeName = $this->model->children->first()->planRegistered->name;
        }
        $this->type = $type;
        self::updatePeriod($periodId);
    }

    public function updatePeriod($id)
    {
        $period = Period::find($id);
        $this->reset(['currentScore', 'beforeScore', 'difScore', 'scores']);
        $periods = Period::query()->with(
            [
                'calendar',
                'children',
                'parents'
            ])->where('calendar_id', $period->calendar_id)
            ->orderBy('start_date', 'desc')
            ->whereDate('start_date', '<=', $period->start_date)
            ->take(12)
            ->get();

        $this->scores = collect([]);

        foreach ($periods->reverse() as $value) {
//            if ($this->model::class != Measure::class) {
//                $this->scores->push($this->model->scoreDashboard($value, $this->model));
//            } else {
            $this->scores->push($this->model->score($value->id));
//            }
        }

        $this->currentScore = $this->scores->firstWhere('period_id', $id);
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

        if ($this->model::class != Measure::class) {
            $this->dispatchBrowserEvent('updateData',
                [
                    'historicalScore' => $this->scores,
                    'score' => $this->currentScore['score'],
                    'difScoreValue' => $this->difScore['value'],
                    'difScoreColor' => $this->difScore['color'],
                ]
            );
        } else {
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
                switch ($this->model->scoringType->code) {
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
    }

    public function render()
    {
        return view('livewire.strategy.dashboard');
    }
}
