<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use App\Events\Measure\MeasureCreated;
use App\Events\Measure\MeasureUpdated;
use App\Models\Auth\User;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaIndicatorConfig;
use App\Traits\HasScore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Measure extends Model
{
    use HasFactory, HasScore;

    const AGGREGATION_TYPE_SUM = 'sum';
    const AGGREGATION_TYPE_AVE = 'ave';
    const AGGREGATION_TYPE_LAST_VALUE = 'last';
    const AGGREGATION_TYPE_NUMBER_OF_YESES = 'number-of-yeses';

    const TYPE_MANUAL = 'Manual';
    const TYPE_GROUPED = 'Agrupado';

    const CATEGORY_TACTICAL = 'Táctico';
    const CATEGORY_OPERATIVE = 'Operativo';

    protected $table = 'msr_measures';

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'data_type',
        'aggregation_type',
        'yes_good',
        'higher_better',
        'base_line',
        'baseline_year',
        'series',
        'category',
        'is_mandatory',
        'national',
        'calendar_id',
        'scoring_type_id',
        'unit_id',
        'source_id',
        'company_id',
        'indicatorable_id',
        'indicatorable_type',
        'user_id',
        'goals_closed',
    ];

    protected $dispatchesEvents = [
        'created' => MeasureCreated::class,
        'updated' => MeasureUpdated::class,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'series' => 'array',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function indicatorable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scoringType(): BelongsTo
    {
        return $this->belongsTo(ScoringType::class, 'scoring_type_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(IndicatorUnits::class, 'unit_id');
    }

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Measure::class, 'msr_measure_grouped', 'measure_id', 'measure_child_id');
    }

    public function scopeChildCalendarFrequency($query, $frequency)
    {
        return $query->whereIn('msr_measures.calendar_id', function ($query) use ($frequency) {
            $query->selectRaw('id')->from('msr_calendars')->whereIn('frequency', Calendar::CALENDARS_CHILD[$frequency]);
        });
    }

    public function score($periodId)
    {
        $period = Period::query()->find($periodId);
        if ($period->calendar_id == $this->calendar_id) {
            $score = $this->scores()->where('period_id', $periodId)->first();

            return [
                'period_id' => $period->id,
                'frequency' => $score->period->name,
                'year' => $score->period->name != $score->period->start_date->year ? $score->period->start_date->year : '',
                'value' => $score->actual,
                'score' => $score->score,
                'thresholds' => $score->thresholds,
                'color' => Score::COLOR[$score->color],
                'cssColor' => $score->color,
                'dataUsed' => [
                    [
                        'id' => $this->id,
                        'name' => $score->period->name,
                        'color' => Score::COLOR[$score->color],
                        'cssColor' => $score->color,
                        'score' => $score->score,
                        'actual' => $score->actual,
                        'thresholds' => $score->thresholds,
                        'type' => 'measure',
                    ]
                ]
            ];
        } else {
            if ($period->days >= $this->calendar->periods->first()->days) {
                $dataUsed = [];
                $scores = $this->scores()->join('msr_periods', 'msr_periods.id', '=', 'msr_scores.period_id')
                    ->orderBy('msr_periods.start_date', 'desc')
                    ->whereDate('msr_periods.start_date', '>=', $period->start_date) // Inicio periodo
                    ->whereDate('msr_periods.end_date', '<=', $period->end_date) // Fin periodo
                    ->select(['msr_scores.*', 'msr_periods.start_date', 'msr_periods.end_date'])
                    ->get();

                $thresholds = $scores->pluck('thresholds')->toArray();
                $final = array_shift($thresholds);
                $actual = null;
                $existAnyValue = $scores->contains(function ($value) {
                    return !is_null($value->actual);
                });
                if ($existAnyValue) {
                    $score = round($scores->avg('score'), 1);
                }
                switch ($this->aggregation_type) {
                    case Measure::AGGREGATION_TYPE_AVE:
                        foreach ($final as $key => &$value) {
                            $value = array_sum(array_column($thresholds, $key)) / count($thresholds);
                        }
                        unset($value);

                        if ($existAnyValue) {
                            $actual = $scores->avg('actual');
                        }
                        break;
                    case Measure::AGGREGATION_TYPE_NUMBER_OF_YESES:
                        if ($existAnyValue) {
                            $actual = $scores->where('actual', 1)->sum('actual');
                        }
                        break;
                    case Measure::AGGREGATION_TYPE_SUM:
                        foreach ($final as $key => &$value) {
                            $value += array_sum(array_column($thresholds, $key));
                        }
                        unset($value);
                        if ($existAnyValue) {
                            $actual = $scores->sum('actual');
                        }

                }

                foreach ($scores->reverse() as $score) {
                    $dataUsed[] = [
                        'id' => $this->id,
                        'name' => $score->period->name != $period->start_date->year ? $score->period->name . ' ' . $period->start_date->year : $score->period->name,
                        'color' => Score::COLOR[$score->color],
                        'cssColor' => $score->color,
                        'score' => $score->score,
                        'actual' => $score->actual,
                        'thresholds' => $score->thresholds,
                        'type' => 'measure',
                    ];
                }

                $scoreAvg = Score::getScore($actual, $this, $final);
                return [
                    'period_id' => $period->id,
                    'frequency' => $period->name,
                    'year' => $period->name != $period->start_date->year ? $period->start_date->year : '',
                    'value' => !is_null($actual) ? round($actual, 2) : null,
                    'score' => !is_null($scoreAvg) ? round($scoreAvg, 1) : null,
                    'thresholds' => $final,
                    'color' => Score::COLOR[Score::colorByScore($scoreAvg)],
                    'cssColor' => Score::colorByScore($scoreAvg),
                    'dataUsed' => $dataUsed
                ];

            }
        }
        return false;
    }

    public function scoreDashboard($period, $model = null)
    {
        if ($period->calendar_id == $this->calendar_id) {
            $score = $this->scores()->where('period_id', $period->id)->first();

            return [
                'period_id' => $period->id,
                'frequency' => $score->period->name,
                'year' => $score->period->name != $score->period->start_date->year ? $score->period->start_date->year : '',
                'value' => $score->actual,
                'score' => $score->score,
                'thresholds' => $score->thresholds,
                'color' => Score::COLOR[$score->color],
                'cssColor' => $score->color,
                'dataUsed' => [
                    [
                        'id' => $this->id,
                        'name' => $score->period->name,
                        'color' => Score::COLOR[$score->color],
                        'cssColor' => $score->color,
                        'score' => $score->score,
                        'actual' => $score->actual,
                        'thresholds' => $score->thresholds,
                        'type' => 'measure',
                    ]
                ]
            ];
        } else {
            if ($period->days >= $this->calendar->periods->first()->days) {
                $dataUsed = [];
                $scores = $this->scores()->join('msr_periods', 'msr_periods.id', '=', 'msr_scores.period_id')
                    ->orderBy('msr_periods.start_date', 'desc')
                    ->whereDate('msr_periods.start_date', '>=', $period->start_date) // Inicio periodo
                    ->whereDate('msr_periods.end_date', '<=', $period->end_date) // Fin periodo
                    ->select(['msr_scores.*', 'msr_periods.start_date', 'msr_periods.end_date'])
                    ->get();

                $thresholds = $scores->pluck('thresholds')->toArray();
                $final = array_shift($thresholds);
                $actual = null;
                $existAnyValue = $scores->contains(function ($value) {
                    return !is_null($value->actual);
                });
                if ($existAnyValue) {
                    $score = round($scores->avg('score'), 1);
                }
                switch ($this->aggregation_type) {
                    case Measure::AGGREGATION_TYPE_AVE:
                        foreach ($final as $key => &$value) {
                            $value = array_sum(array_column($thresholds, $key)) / count($thresholds);
                        }
                        unset($value);

                        if ($existAnyValue) {
                            $actual = $scores->avg('actual');
                        }
                        break;
                    case Measure::AGGREGATION_TYPE_NUMBER_OF_YESES:
                        if ($existAnyValue) {
                            $actual = $scores->where('actual', 1)->sum('actual');
                        }
                        break;
                    case Measure::AGGREGATION_TYPE_SUM:
                        foreach ($final as $key => &$value) {
                            $value += array_sum(array_column($thresholds, $key));
                        }
                        unset($value);
                        if ($existAnyValue) {
                            $actual = $scores->sum('actual');
                        }

                }

                foreach ($scores->reverse() as $score) {
                    $dataUsed[] = [
                        'id' => $this->id,
                        'name' => $score->period->name != $period->start_date->year ? $score->period->name . ' ' . $period->start_date->year : $score->period->name,
                        'color' => Score::COLOR[$score->color],
                        'cssColor' => $score->color,
                        'score' => $score->score,
                        'actual' => $score->actual,
                        'thresholds' => $score->thresholds,
                        'type' => 'measure',
                    ];
                }

                $scoreAvg = Score::getScore($actual, $this, $final);
                return [
                    'period_id' => $period->id,
                    'frequency' => $period->name,
                    'year' => $period->name != $period->start_date->year ? $period->start_date->year : '',
                    'value' => !is_null($actual) ? round($actual, 2) : null,
                    'score' => !is_null($scoreAvg) ? round($scoreAvg, 1) : null,
                    'thresholds' => $final,
                    'color' => Score::COLOR[Score::colorByScore($scoreAvg)],
                    'cssColor' => Score::colorByScore($scoreAvg),
                    'dataUsed' => $dataUsed
                ];

            }
        }
        return false;
    }

    public function getGoal(array $thresholds)
    {
        switch ($this->scoringType->code) {
            case(ScoringType::TYPE_GOAL_RED_FLAG):
                return $thresholds[2];
            case(ScoringType::TYPE_THREE_COLORS):
                return $thresholds[3];
        }
        return null;
    }

    /**
     * Obtener las actividades poa
     *
     * @return HasMany
     */
    public function poaActivities(): HasMany
    {
        return $this->hasMany(PoaActivity::class, 'measure_id');
    }

    public function poaConfigs(): HasMany
    {
        return $this->hasMany(PoaIndicatorConfig::class, 'measure_id');
    }

    /**
     * @return BelongsTo
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
