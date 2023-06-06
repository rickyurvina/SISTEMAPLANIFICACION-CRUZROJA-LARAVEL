<?php

namespace App\Http\Controllers\Indicators\Thresholds;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Indicator\Threshold\ThresholdRequest;
use App\Jobs\Indicators\Thresholds\CreateThreshold;
use App\Jobs\Indicators\Thresholds\DeleteThreshold;
use App\Jobs\Indicators\Thresholds\UpdateThreshold;
use App\Models\Indicators\Threshold\Threshold;
use Throwable;


class ThresHoldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:admin-manage-catalogs', ['only' => ['index']]);
    }
    /**
     * /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('indicator.threshold.index');
    }
}
