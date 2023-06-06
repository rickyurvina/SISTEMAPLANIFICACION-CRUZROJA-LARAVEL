<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TemplateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('azure');
        $this->middleware('permission:strategy-manage-templates|strategy-manage|strategy-view-templates', ['only' => ['index']]);
        $this->middleware('permission:strategy-manage-templates|strategy-manage', ['only' => ['edit']]);
    }

    /**
     * Calls Plan templates configuration default view
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('modules.strategy.template.index');
    }

    /**
     * Calls Plan template maintenance view
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('modules.strategy.template.edit')->with('id', $id);
    }
}
