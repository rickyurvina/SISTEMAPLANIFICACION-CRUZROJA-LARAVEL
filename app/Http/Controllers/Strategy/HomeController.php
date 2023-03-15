<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Measure\ScoringType;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanTemplate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class HomeController extends Controller
{

    public Collection $planDetails;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('strategy-read-strategy');
        $plan = Plan::with(['children.scores'])->type(PlanTemplate::PLAN_STRATEGY_CRE)->first();

        return view('modules.strategy.home.index', [
            'plan' => $plan,
            'periodId' => self::periodId(),
            'type' => 'objective'
        ]);
    }

    public function showDetail($id, $type)
    {
        $this->authorize('strategy-read-strategy');

        if ($type == 'objective') {
            $model = PlanDetail::with([
                'plan',
                'children.scores',
                'measures'
            ])->find($id);
        } else {
            $model = Measure::find($id);
        }

        return view('modules.strategy.home.show', [
            'model' => $model,
            'periodId' => self::periodId(),
            'type' => $type,
            'planId' => Plan::type(PlanTemplate::PLAN_STRATEGY_CRE)->first()->id
        ]);
    }

    private function periodId()
    {
        if (session()->exists('periodId')) {
            return session('periodId');
        } else {
            $period = Period::where([
                ['start_date', '<=', now()->format('Y-m-d')],
                ['end_date', '>=', now()->format('Y-m-d')],
            ])->whereRelation('calendar', 'frequency', Calendar::FREQUENCY_MONTHLY)->first();

            session(['periodId' => $period->id]);
            return $period->id;
        }
    }
}
