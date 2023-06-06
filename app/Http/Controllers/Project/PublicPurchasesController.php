<?php

namespace App\Http\Controllers\Project;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use Illuminate\View\View;

class PublicPurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:project-manage|project-super-admin');
        $this->middleware('permission:project-settings',['only'=>['index']]);
    }

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
