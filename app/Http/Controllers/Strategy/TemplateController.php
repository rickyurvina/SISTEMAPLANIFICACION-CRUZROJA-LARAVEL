<?php

namespace App\Http\Controllers\Strategy;

use App\Abstracts\Http\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TemplateController extends Controller
{
    /**
     * Calls Plan templates configuration default view
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        if (user()->cannot('strategy-crud-strategy') && user()->cannot('strategy-read-strategy') && user()->cannot('strategy-template-crud-strategy')) {
            abort(403);
        }
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
        if (user()->cannot('strategy-crud-strategy') && user()->cannot('strategy-template-crud-strategy')) {
            abort(403);
        }
        return view('modules.strategy.template.edit')->with('id', $id);
    }
}
