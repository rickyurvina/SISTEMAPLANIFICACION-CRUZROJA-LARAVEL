<?php

namespace App\Http\Controllers\Project\Configuration;

use App\Abstracts\Http\Controller;
use App\Models\Projects\Configuration\ProjectThreshold;
use Illuminate\View\View;


class ProjectThresholds extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules.project.configuration.thresholds');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ProjectThreshold $ProjectThreshold
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectThreshold $ProjectThreshold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectThreshold  $ProjectThreshold
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectThreshold $ProjectThreshold)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectThreshold  $ProjectThreshold
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectThreshold $ProjectThreshold)
    {
        //
    }
}
