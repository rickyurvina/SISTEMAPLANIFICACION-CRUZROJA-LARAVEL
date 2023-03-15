<?php

namespace App\Http\Controllers\Budget\Catalogs;


use App\Abstracts\Http\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class BudgetClassifierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('modules.budget.catalogs.budget-classifier');
    }
}
