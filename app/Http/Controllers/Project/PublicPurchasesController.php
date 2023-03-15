<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use Illuminate\View\View;

class PublicPurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('modules.project.configuration.catalog-purchases');
    }
}
