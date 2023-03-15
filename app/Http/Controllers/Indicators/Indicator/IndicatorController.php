<?php

namespace App\Http\Controllers\Indicators\Indicator;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Indicator\Indicator\IndicatorRequest;
use App\Http\Requests\Indicator\Indicator\UpdateIndicatorRequest;
use App\Jobs\Indicators\Indicator\CreateIndicator;
use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Auth\User;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Units\IndicatorUnits;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('indicator.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function store(IndicatorRequest $request)
    {
        try {
            $response = $this->ajaxDispatch(new CreateIndicator($request));
            if ($response['success']) {
                $response['redirect'] = route('indicators.index');
                $message = trans_choice('messages.success.added', 0, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->success();
                return redirect()->route('indicators.index');
            } else {
                $response['redirect'] = route('indicators.index');
                $message = $response['message'];
                flash($message)->error();
                return redirect()->route('indicators.index');
            }

        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $response = $this->ajaxDispatch(new DeleteIndicator($id));
            if ($response['success']) {
                if ($response['data']) {
                    $response['redirect'] = route('indicators.index');
                    $message = trans_choice('messages.error.indicator_with_progress', 1, ['type' => trans_choice('general.indicators', 1)]);
                    flash($message)->error();
                    return redirect()->back();
                } else {
                    $response['redirect'] = route('indicators.index');
                    $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
                    flash($message)->success();
                    return redirect()->back();
                }
            } else {
                $response['redirect'] = route('indicators.index');
                $message = $response['message'];
                flash($message)->error();
                return redirect()->back();
            }
        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->back();
        }
    }

}
