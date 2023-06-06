<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Jobs\Strategy\UpdateScoresStrategy;
use App\Models\Measure\Calendar;
use App\Models\Measure\Measure;
use App\Models\Measure\Period;
use Illuminate\Support\Facades\Config;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:strategy-manage|strategy-view|strategy-update-indicators',
            [
                'only' => [
                    'index', 'detail'
                ]]);
        $this->middleware('permission:strategy-manage|strategy-update-indicators',
            [
                'only' => [
                    'updateByPeriod', 'destroy'
                ]]);
    }

    public function index()
    {
        $cardMeasures = Config::get('constants.catalog.MEASURE_CARD_UPDATES');
        return view('common.measure.index', ['cardMeasures' => $cardMeasures]);
    }

    public function updateByPeriod()
    {
        $period = Period::where([
            ['start_date', '<=', now()->format('Y-m-d')],
            ['end_date', '>=', now()->format('Y-m-d')],
        ])->whereRelation('calendar', 'frequency', Calendar::FREQUENCY_MONTHLY)->first();
        return view('common.measure.update-by-period', ['periodId' => $period->id]);
    }

    public function updateByFrequency()
    {
        return view('common.measure.update-by-frequency');
    }

    public function destroy(Measure $measure)
    {
        $measure->scores()->delete();
        $measure->delete();
        $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
        flash($message)->success();
        return redirect()->back();
    }

    public function updateScores(){
//        $this->ajaxDispatch(new UpdateScoresStrategy());
        UpdateScoresStrategy::dispatch();
        flash('La estrategia se esta actualizando en segundo plano, esto puede tomar varios minutos.')->success();
        return redirect()->route('strategy.home');
    }
}
