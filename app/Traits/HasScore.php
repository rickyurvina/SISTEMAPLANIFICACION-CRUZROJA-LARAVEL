<?php

namespace App\Traits;

use App\Models\Measure\Period;
use App\Models\Measure\Score;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

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
        if ($model->hasRelation('measures')) {
            foreach ($model->measures()->get() as $measure) {
                $sc = Score::where('scoreable_type', $measure::class)
                    ->where('scoreable_id', $measure->id)
                    ->where('period_id', $period->id)
                    ->first();
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
                $scoreOfPeriod = Score::where('scoreable_type', $child::class)
                    ->where('scoreable_id', $child->id)
                    ->where('period_id', $period->id)
                    ->first();
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

        $scoreModel = Score::where('scoreable_type', $model::class)
            ->where('scoreable_id', $model->id)
            ->where('period_id', $period->id)
            ->first();
        return [
            'period_id' => $period->id,
            'frequency' => $period->name,
            'year' => $period->name != $period->start_date->year ? $period->start_date->year : '',
            'value' => $scoreModel->score ? round($scoreModel->score, 1) : null,
            'score' => $scoreModel->score ? round($scoreModel->score, 1) : null,
            'thresholds' => [],
            'color' => $scoreModel->color ? Score::COLOR[Score::colorByScore($scoreModel->score)] : Score::COLOR[Score::colorByScore(null)],
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
                    'class' => $measure::class,
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
                'class' => $child::class,
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

    /**
     * @param Period $period
     * @return void
     */
    public function updateScore(Period $period)
    {
        $periodId = $period->id;
        $calculatedScore = null;
        $score = null;
        $count = 0;

        if ($this->hasRelation('measures')) {
            foreach ($this->measures()->get() as $measure) {
                $sc = $measure->score($periodId);
                if ($sc && !is_null($sc['score'])) {
                    $score += $sc['score'] * $measure->weight;
                    $count += $measure->weight;
                }

                $scoreMeasure = Score::where('scoreable_type', $measure::class)
                    ->where('scoreable_id', $measure->id)
                    ->where('period_id', $periodId)
                    ->first();

                if ($scoreMeasure && is_numeric($sc)) {
                    $scoreMeasure->score = $sc ? round($sc, 1) : null;
                    $scoreMeasure->save();
                }
            }
        }

        foreach ($this->children()->get() as $child) {
            $sc = $child->childScore($child, $periodId);
            if ($sc && !is_null($sc)) {
                $score += $sc * $child->weight;
                $count += $child->weight;
            }

            $scorePlanDetail = Score::where('scoreable_type', $child::class)
                ->where('scoreable_id', $child->id)
                ->where('period_id', $periodId)
                ->first();
            if ($scorePlanDetail) {
                if ($sc > 0) {
                    $scorePlanDetail->score = $sc ? round($sc, 1) : null;
                    $scorePlanDetail->save();
                }
            }
        }

        if ($count) {
            $calculatedScore = $score / $count;
        }
        $scoreModel = Score::where('scoreable_type', $this::class)
            ->where('scoreable_id', $this->id)
            ->where('period_id', $periodId)
            ->first();
        if ($scoreModel) {
            $scoreModel->score = $calculatedScore ? round($calculatedScore, 1) : null;
            $scoreModel->save();
        }
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
