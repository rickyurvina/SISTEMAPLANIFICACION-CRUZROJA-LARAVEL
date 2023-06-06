<?php

namespace App\Http\Controllers\Project\Configuration;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Models\Projects\Configuration\ProjectThreshold;
use Illuminate\View\View;


class ProjectThresholds extends Controller
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
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.project.configuration.thresholds');
    }
}
