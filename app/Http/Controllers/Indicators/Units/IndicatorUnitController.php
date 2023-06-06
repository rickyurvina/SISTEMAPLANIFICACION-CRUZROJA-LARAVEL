<?php

namespace App\Http\Controllers\Indicators\Units;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Indicator\Units\IndicatorUnitsRequest;
use App\Jobs\Indicators\Units\CreateUnitIndicator;
use App\Jobs\Indicators\Units\DeleteUnitIndicator;
use App\Jobs\Indicators\Units\UpdateUnitIndicator;
use App\Models\Indicators\Units\IndicatorUnits;
use Throwable;

class IndicatorUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:admin-manage-catalogs', ['only' => ['index','create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $units = IndicatorUnits::orderBy('id','asc')->collect();
            return view('indicator.units.index', ['units' => $units]);
        } catch (Throwable $e) {
            flash($e)->error();
            return redirect()->back();
        }
    }
}
