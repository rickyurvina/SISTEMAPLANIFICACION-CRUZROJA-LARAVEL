<?php

namespace Database\Seeders;

use App\Models\Measure\Calendar;
use App\Models\Measure\Score;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Illuminate\Database\Seeder;

class CreateScoreOnPlanAndPlanDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calendars = Calendar::whereIn('frequency', Calendar::CALENDARS)
            ->with('periods')
            ->get();
        $plan = Plan::with(['planDetails.measures'])->type(Plan::TYPE_STRATEGY)->active()->first();
        $existScoresPlan = Score::where('scoreable_type', Plan::class)
            ->where('scoreable_id', $plan->id)->get()->count();
        if (!$existScoresPlan) {
            foreach ($calendars as $calendar) {
                foreach ($calendar->periods as $period) {
                    Score::create([
                        'color' => 'gray',
                        'thresholds' => [],
                        'period_id' => $period->id,
                        'scoreable_type' => $plan::class,
                        'scoreable_id' => $plan->id,
                    ]);
                }
            }
        }
        $planDetails = $plan->planDetails;
        $existScoresPd = Score::where('scoreable_type', PlanDetail::class)
            ->whereIn('scoreable_id', $planDetails->pluck('id')->toArray())->get()->count();
        if (!$existScoresPd) {
            foreach ($planDetails as $planDetail) {
                foreach ($calendars as $calendar) {
                    foreach ($calendar->periods as $period) {
                        Score::create([
                            'color' => 'gray',
                            'thresholds' => [],
                            'period_id' => $period->id,
                            'scoreable_type' => $planDetail::class,
                            'scoreable_id' => $planDetail->id,
                        ]);
                    }
                }
            }
        }
    }
}
