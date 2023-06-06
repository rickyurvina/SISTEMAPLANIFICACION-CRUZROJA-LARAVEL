<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use App\Events\Measure\ScoreUpdated;
use App\Listeners\Scores\UpdateParentScores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Score extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $table = 'msr_scores';

    protected $fillable = [
        'actual',
        'score',
        'color',
        'goal',
        'variance',
        'variance_percent',
        'toward_goal_percent',
        'data_type',
        'thresholds',
        'period_id',
        'scoreable_type',
        'scoreable_id',
    ];

    protected $casts = [
        'thresholds' => 'array',
    ];

    public const COLOR = [
        'gray' => '#eff3f7',
        'red' => '#f25131',
        'green' => '#96cd00',
        'yellow' => '#fbcc3b',
    ];

    /**
     * @param $value
     * @return float|null
     */
    public function getScoreAttribute($value): ?float
    {
        return is_null($value) ? $value : round($value, 1);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->scoreable_type == Measure::class) {
                $model->actual = $model->actual == '' ? null : $model->actual;
                $model->score = self::getScore($model->actual, $model->scoreable, $model->thresholds);
            }
            $model->color = self::getColor($model);
        });
    }


    /**
     * @param $model
     * @return string
     */
    public static function getColor($model): string
    {
        if (is_null($model->score)) {
            return 'gray';
        }
        if ($model->scoreable_type == Measure::class) {
            switch ($model->scoreable->scoringType->code) {
                case ScoringType::TYPE_YES_NO:
                    if ($model->scoreable->yes_good) {
                        return $model->score == 100 ? 'green' : 'red';
                    } else {
                        return $model->score == 0 ? 'green' : 'red';
                    }
                case ScoringType::TYPE_GOAL_ONLY:
                    if ($model->scoreable->higher_better) {
                        return $model->score == 100 ? 'green' : 'red';
                    } else {
                        return $model->score == 0 ? 'green' : 'red';
                    }
                case ScoringType::TYPE_GOAL_RED_FLAG:
                case ScoringType::TYPE_THREE_COLORS:
                    if ($model->score <= 33.33333) {
                        return 'red';
                    } elseif ($model->score < 66.66667) {
                        return 'yellow';
                    } else {
                        return 'green';
                    }
                case ScoringType::TYPE_TWO_COLORS:
                    if ($model->score < 50) {
                        return 'red';
                    } else {
                        return 'green';
                    }
            }
        } else {
            return self::colorByScore($model->score);
        }
        return 'gray';
    }

    /**
     * @param $actual
     * @param $scoreable
     * @param $thresholds
     * @return float|int|mixed|null
     */
    public static function getScore($actual, $scoreable, $thresholds): mixed
    {
        if (is_null($actual)) {
            return null;
        }

        if (!$scoreable || !$scoreable->scoringType) {
            return null;
        }
        $score = null;
        $config = $scoreable->scoringType->config;
        switch ($scoreable->scoringType->code) {
            case ScoringType::TYPE_YES_NO:
                if ($scoreable->yes_good) {
                    $score = $actual ? 100 : 0;
                } else {
                    $score = !$actual ? 100 : 0;
                }
                break;
            case ScoringType::TYPE_GOAL_ONLY:
                if ($scoreable->higher_better) {
                    $score = $actual >= $thresholds[1] ? 100 : 0;
                } else {
                    $score = $actual <= $thresholds[1] ? 100 : 0;
                }
                break;
            case ScoringType::TYPE_GOAL_RED_FLAG:
                $difThreshold = $thresholds[2] - $thresholds[1];
                if ($actual <= $thresholds[1]) {
                    $difScore = $config[1]['value'];
                    $score = self::scoreRange($actual, $thresholds[1] - $difThreshold, $difThreshold, $difScore);
                } elseif ($actual <= $thresholds[2]) {
                    $difScore = $config[2]['value'] - $config[1]['value'];
                    $score = self::scoreRange($actual, $thresholds[1], $difThreshold, $difScore, $config[1]['value']);
                } else {
                    $difScore = 10 - $config[2]['value'];
                    $score = self::scoreRange($actual, $thresholds[2], $difThreshold, $difScore, $config[2]['value']);
                }
                break;
            case ScoringType::TYPE_TWO_COLORS:
            case ScoringType::TYPE_THREE_COLORS:
                $len = count($thresholds);
                $isAscending = $thresholds[$len] > $thresholds[1];
                foreach ($thresholds as $index => $value) {
                    if ($index == 1) {
                        // first
                        if ($isAscending) {
                            if ($actual <= $value) {
                                return $config[$index]['value'];
                            }
                        } else {
                            if ($actual >= $value) {
                                return $config[$index]['value'];
                            }
                        }
                        continue;
                    }

                    if ($index == $len) {
                        // last
                        if ($isAscending) {
                            if ($actual >= $value) {
                                return $config[$index]['value'];
                            }
                        } else {
                            if ($actual <= $value) {
                                return $config[$index]['value'];
                            }
                        }
                    }

                    $difThreshold = $value - $thresholds[$index - 1];
                    $difScore = $config[$index]['value'] - $config[$index - 1]['value'];
                    if ($isAscending) {
                        if ($actual <= $value) {
                            return self::scoreRange($actual, $thresholds[$index - 1], $difThreshold, $difScore, $config[$index - 1]['value']);
                        }
                    } else {
                        if ($actual >= $value) {
                            return self::scoreRange($actual, $thresholds[$index - 1], $difThreshold, $difScore, $config[$index - 1]['value']);
                        }
                    }
                }
        }
        return $score;
    }

    /**
     * @param $val
     * @param $valMin
     * @param $difThreshold
     * @param $difScore
     * @param $score
     * @return float|int
     */
    private static function scoreRange($val, $valMin, $difThreshold, $difScore, $score = 0): float|int
    {
        $scale = $difScore / $difThreshold;
        $difActualValue = $val - $valMin;
        $score += $scale * $difActualValue;
        return $score < 0 ? 0 : ($score > 100 ? 100 : $score);
    }

    /**
     * @param $score
     * @return string
     */
    public static function colorByScore($score): string
    {
        if (is_null($score)) {
            return 'gray';
        }

        if ($score <= 33.33333) {//TODO SERIA MEJOR DIVIDIR 100/3 TENER EL VALOR EXACTO IGUGAL EN EL OTRO SERIA MEJOR 100/2
            return 'red';
        } elseif ($score < 66.66667) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    /**
     * @return MorphTo
     */
    public function scoreable(): MorphTo
    {
        return $this->morphTo()->withoutGlobalScopes();
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
