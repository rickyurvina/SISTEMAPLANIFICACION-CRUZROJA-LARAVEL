<?php

namespace App\Http\Livewire\Measure;

use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Period;
use Carbon\Carbon;
use Livewire\Component;

class Report extends Component
{

    public $periodId = null;

    public $model = null;

    public $periods = [];

    public $metrics = [];

    public int $numberOfPeriod = 12;

    public array $options = [];

    protected $listeners = ['period-changed' => 'updatePeriod'];

    public function mount($periodId, $model)
    {
        $this->model = $model;
        $this->periodId = $periodId;

        $this->options = [
            'showActual' => ['show' => true, 'label' => 'Valor del indicador'],
            'showScore' => ['show' => false, 'label' => 'Score'],
            'showGoal' => ['show' => false, 'label' => 'Meta'],
            'showVariance' => ['show' => false, 'label' => 'Variación a la meta'],
            'showVariancePercent' => ['show' => false, 'label' => '% de variación a la meta'],
            'showTowardGoalPercent' => ['show' => false, 'label' => '% hacia la meta'],
        ];

        self::init();
    }

    public function init()
    {
        $period = Period::find($this->periodId);
        $this->periods = Period::query()->where('calendar_id', $period->calendar_id)
            ->orderBy('start_date', 'desc')
            ->whereDate('start_date', '<=', $period->start_date)
            ->take($this->numberOfPeriod)
            ->get()->reverse();
        $this->metrics = [];

        if ($this->model::class == Measure::class) {
            self::getMetrics($this->model);
        } else {
            foreach ($this->model->measures as $measure) {
                self::getMetrics($measure);
            }
        }
    }

    private function getMetrics($measure)
    {
        $scData = [];
        foreach ($this->periods as $value) {
            $score = $measure->score($value['id']);
            $data = [
                'periodId' => $value['id'],
                'color' => $score ? $score['cssColor'] : '',
            ];
            if ($this->options['showActual']['show']) {
                $data['actual'] = $score ? $score['value'] : '';
            }
            if ($this->options['showScore']['show']) {
                $data['score'] = $score ? $score['score'] : '';
            }
            if ($this->options['showGoal']['show']) {
                $data['goal'] = $score ? $measure->getGoal($score['thresholds']) : '';
            }
            if ($this->options['showVariance']['show']) {
                $goal = $score ? $measure->getGoal($score['thresholds']) : '';
                $data['variance'] = $score ? $score['value'] - $goal : '';
            }
            if ($this->options['showVariancePercent']['show']) {
                $goal = $score ? $measure->getGoal($score['thresholds']) : '';
                $data['variancePercent'] = $score && $goal != 0 && $score['value'] ? round(($score['value'] / $goal - 1) * 100, 1) . '%' : '';
            }
            if ($this->options['showTowardGoalPercent']['show']) {
                $goal = $score ? $measure->getGoal($score['thresholds']) : '';
                $data['towardGoalPercent'] = $score && $goal != 0 && $score['value'] ? round(($score['value'] / $goal) * 100, 1) . '%' : '';
            }
            $scData[] = $data;
        }
        $this->metrics[] = [
            'id' => $measure->id,
            'dataType' => $measure->data_type,
            'label' => $measure->name,
            'scores' => $scData
        ];
    }

    public function updatePeriod($id)
    {
        $this->periodId = $id;
        self::init();
    }

    public function getPeriodName($period)
    {
        if ($period['calendar']['frequency'] === Calendar::FREQUENCY_YEARLY) {
            return $period['name'];
        }

        return $period['name'] . ' ' . Carbon::parse($period['start_date'])->year;
    }

    public function showOptions()
    {
        self::init();
    }

    public function countOptions()
    {
        return count(array_filter(array_column(array_values($this->options), 'show')));
    }

    public function selectedOptions()
    {
        return array_filter($this->options, function ($v) {
            return $v['show'];
        });
    }

    public function render()
    {
        return view('livewire.measure.report');
    }
}
