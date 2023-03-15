<?php

namespace App\Http\Controllers\Indicators\Sources;

use App\Http\Requests\Indicator\Sources\IndicatorSourceRequest;
use App\Jobs\Indicators\Sources\CreateSource;
use App\Jobs\Indicators\Sources\DeleteSource;
use App\Jobs\Indicators\Sources\UpdateSource;
use App\Models\Indicators\Sources\IndicatorSource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Abstracts\Http\Controller;

class IndicatorSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('indicator.sources.index');
    }
}
