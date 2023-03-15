<?php

namespace App\Http\Controllers\AdministrativeTasks;

use App\Abstracts\Http\Controller;
use App\Http\Requests\StoreAdministrativeSubTaskRequest;
use App\Http\Requests\UpdateAdministrativeSubTaskRequest;
use App\Models\AdministrativeTasks\AdministrativeSubTask;

class AdministrativeSubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdministrativeSubTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdministrativeSubTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdministrativeTasks\AdministrativeSubTask  $administrativeSubTask
     * @return \Illuminate\Http\Response
     */
    public function show(AdministrativeSubTask $administrativeSubTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdministrativeTasks\AdministrativeSubTask  $administrativeSubTask
     * @return \Illuminate\Http\Response
     */
    public function edit(AdministrativeSubTask $administrativeSubTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdministrativeSubTaskRequest  $request
     * @param  \App\Models\AdministrativeTasks\AdministrativeSubTask  $administrativeSubTask
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrativeSubTaskRequest $request, AdministrativeSubTask $administrativeSubTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdministrativeTasks\AdministrativeSubTask  $administrativeSubTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $administrativeSubTask_id)
    {

    }
}
