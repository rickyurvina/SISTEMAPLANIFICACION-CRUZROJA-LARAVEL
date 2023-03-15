<?php

namespace App\Traits;

use App\Models\Measure\Period;
use App\Models\Measure\Score;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasScore
{
    public function getScorePeriod($periodId)
    {
        return $this->scores()->firstWhere('period_id', $periodId);
    }

    /**
     * @return MorphMany
     */
    public function scores(): MorphMany
    {
        return $this->morphMany(Score::class, 'scoreable');
    }

    /**
     * @param $periodId
     * @return array
     */
    public function scoreDashboard(Period $period, $model): array
    {
        $dataUsed = [];
        $score = null;
        $count = 0;
        $calculatedScore = null;

        if ($model->hasRelation('measures')) {
            foreach ($model->measures()->get() as $measure) {
                $sc = $measure->score($period->id);
                if ($sc && !is_null($sc['score'])) {
                    $score += $sc['score'] * $measure->weight;
                    $count += $measure->weight;
                }
                $dataUsed[] = [
                    'id' => $measure->id,
                    'code' => $measure->code,
                    'name' => $measure->name,
                    'icon' => $measure->unit->getIcon(),
                    'color' => $sc && !is_null($sc['score']) ? $sc['color'] : Score::COLOR[Score::colorByScore(null)],
                    'score' => $sc && !is_null($sc['score']) ? round($sc['score'], 1) : null,
                    'actual' => null,
                    'weight' => $measure->weight,
                    'thresholds' => [],
                    'type' => 'measure',
                ];
            }
        }

        if ($model->children->count()) {
            foreach ($model->children()->get() as $child) {
                $scoreOfPeriod = $child->scores()->wherePeriodId($period->id)->first();
                if ($scoreOfPeriod) {
                    $score += $scoreOfPeriod->score * $child->weight;
                    $count += $child->weight;
                }
                $dataUsed[] = [
                    'id' => $child->id,
                    'code' => $child->code,
                    'name' => $child->name,
                    'color' => $scoreOfPeriod->color ? Score::COLOR[Score::colorByScore($scoreOfPeriod->score)] : Score::COLOR[Score::colorByScore(null)],
                    'score' => $scoreOfPeriod->score ? round($scoreOfPeriod->score, 1) : null,
                    'actual' => null,
                    'weight' => $child->weight,
                    'thresholds' => [],
                    'type' => 'objective',
                ];
            }
        }

        if ($count) {
            $calculatedScore = $score / $count;
        }

        return [
            'period_id' => $period->id,
            'frequency' => $period->name,
            'year' => $period->name != $period->start_date->year ? $period->start_date->year : '',
            'value' => $calculatedScore ? round($calculatedScore, 1) : null,
            'score' => $calculatedScore ? round($calculatedScore, 1) : null,
            'thresholds' => [],
            'color' => Score::COLOR[Score::colorByScore($calculatedScore)],
            'dataUsed' => $dataUsed
        ];
    }

    public function score($periodId)
    {
        $period = Period::query()->find($periodId);
        $calculatedScore = null;
        $score = null;
        $count = 0;
        $dataUsed = [];

        if ($this->hasRelation('measures')) {
            foreach ($this->measures()->get() as $measure) {
                $sc = $measure->score($periodId);
                if ($sc && !is_null($sc['score'])) {
                    $score += $sc['score'] * $measure->weight;
                    $count += $measure->weight;
                }
                $dataUsed[] = [
                    'id' => $measure->id,
                    'code' => $measure->code,
                    'name' => $measure->name,
                    'color' => $sc && !is_null($sc['score']) ? $sc['color'] : Score::COLOR[Score::colorByScore(null)],
                    'score' => $sc && !is_null($sc['score']) ? round($sc['score'], 1) : null,
                    'actual' => null,
                    'weight' => $measure->weight,
                    'thresholds' => [],
                    'type' => 'measure',
                ];
            }
        }

        foreach ($this->children()->get() as $child) {
            $sc = $child->childScore($child, $periodId);
            if ($sc && !is_null($sc)) {
                $score += $sc * $child->weight;
                $count += $child->weight;
            }
            $dataUsed[] = [
                'id' => $child->id,
                'code' => $child->code,
                'name' => $child->name,
                'color' => $sc ? Score::COLOR[Score::colorByScore($sc)] : Score::COLOR[Score::colorByScore(null)],
                'score' => $sc ? round($sc, 1) : null,
                'actual' => null,
                'weight' => $child->weight,
                'thresholds' => [],
                'type' => 'objective',
            ];
        }

        if ($count) {
            $calculatedScore = $score / $count;
        }

        return [
            'period_id' => $period->id,
            'frequency' => $period->name,
            'year' => $period->name != $period->start_date->year ? $period->start_date->year : '',
            'value' => $calculatedScore ? round($calculatedScore, 1) : $calculatedScore,
            'score' => $calculatedScore ? round($calculatedScore, 1) : $calculatedScore,
            'thresholds' => [],
            'color' => Score::COLOR[Score::colorByScore($calculatedScore)],
            'dataUsed' => $dataUsed
        ];
    }

    public function childScore($child, $periodId)
    {
        $result = null;
        $score = null;
        $count = 0;

        foreach ($child->measures as $measure) {
            $sc = $measure->score($periodId);
            if ($sc && !is_null($sc['score'])) {
                $score += $sc['score'] * $measure->weight;
                $count += $measure->weight;
            }
        }

        foreach ($child->children()->get() as $item) {
            $sc = $item->childScore($item, $periodId);
            if (!is_null($sc)) {
                $score += $sc * $item->weight;
                $count += $item->weight;
            }
        }
        if ($count) {
            $result = $score / $count;
        }

        return $result;
    }
}
