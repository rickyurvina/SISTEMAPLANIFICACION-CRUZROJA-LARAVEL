<?php

namespace App\Http\Controllers\Process;

use App\Abstracts\Http\Controller;
use App\Http\Middleware\Azure\Azure;
use App\Models\Process\NonConformities;

class NonConformitiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(Azure $azure)
    {
        $this->middleware('azure');
        $this->middleware('permission:process-manage');
        $this->middleware('permission:process-manage-conformities',
            [
                'only' => [
                    'edit',
                    'destroy'
                ]]);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Process\NonConformities  $nonConformities
     * @return \Illuminate\Http\Response
     */
    public function edit(NonConformities $nonConformities,$subMenu, $page)
    {
        $nonConformities->load(['process']);
        $process = $nonConformities->process;
        return view('modules.process.nonConformities.edit', ['process' => $process, 'nonConformities' => $nonConformities, 'subMenu' => $subMenu, 'page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Process\NonConformities  $nonConformities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, string $page)
    {
        $nonConformity = NonConformities::find($id);
        $response = $this->ajaxDispatch(new \App\Jobs\Process\DeleteNonConformity($nonConformity));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans('general.nonconformity')]))->success();
            return redirect()->route('process.showConformities', [$nonConformity->process_id, $page]);
        } else {
            flash($response['message'])->error();
            return redirect()->route('process.showConformities', [$nonConformity->process_id, $page]);
        }
    }
}
