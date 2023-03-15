<?php

namespace App\Listeners\Measure;

use App\Events\Measure\ScoreMonthlyUpdated;
use App\Models\Strategy\Plan;

class UpdateElementsScore
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ScoreMonthlyUpdated $event
     */
    public function handle(ScoreMonthlyUpdated $event)
    {
        $item = $event->item;
        $periodId = $event->periodId;
        $score = null;
        $count = 0;
        foreach ($item->measures as $measure) {
            $sc = $measure->getScorePeriod($periodId);
            if ($sc && $sc->score) {
                $score += $sc->score * $measure->weight;
                $count += $measure->weight;
            }
        }
        $scoreModel = $item->scores()->where('period_id', $periodId)->first();

        if ($count) {
            $scoreModel->score = round($score / $count, 1);
            $scoreModel->save();
        }

        if ($item->parent_id == null) {
            self::updateParents($item->plan, $periodId);
        } else {
            self::updateParents($item->parent, $periodId);
        }
    }

    private function updateParents($item, $periodId)
    {
        $score = null;
        $count = 0;
        if ($item::class == Plan::class) {
            foreach ($item->children()->get() as $child) {
                $sc = $child->getScorePeriod($periodId);
                if ($sc && $sc->score) {
                    $score += $sc->score * $child->weight;
                    $count += $child->weight;
                }
            }
            $scoreModel = $item->scores()->where('period_id', $periodId)->first();

            if ($count) {
                $scoreModel->score = $score / $count;
                $scoreModel->save();
            }
            return;
        }

        if ($item->parent_id == null) {
            return self::updateParents($item->plan, $periodId);
        }

        foreach ($item->children()->get() as $child) {
            $sc = $child->getScorePeriod($periodId);
            if ($sc && $sc->score) {
                $score += $sc->score;
                $count++;
            }
        }
        $scoreModel = $item->scores()->where('period_id', $periodId)->first();

        if ($count) {
            $scoreModel->score = $score / $count;
            $scoreModel->save();
        }

        return self::updateParents($item->parent, $periodId);
    }
}
