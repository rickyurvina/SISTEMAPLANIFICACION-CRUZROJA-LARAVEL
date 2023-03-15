<?php

namespace App\Http\Controllers\Process;

use App\Abstracts\Http\Controller;
use App\Models\Process\ProcessPlanChanges;
use Illuminate\Http\Request;

class ProcessPlanChangesController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProcessPlanChanges $processPlanChanges
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(ProcessPlanChanges $processPlanChanges,$subMenu, $page)
    {
        $processPlanChanges->load(['process']);
        $process = $processPlanChanges->process;
        return view('modules.process.planChanges.edit', ['process' => $process, 'processPlanChanges' => $processPlanChanges, 'subMenu' => $subMenu, 'page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProcessPlanChanges $processPlanChanges
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, string $page)
    {
        $processPlanChanges = ProcessPlanChanges::find($id);
        $response = $this->ajaxDispatch(new \App\Jobs\Process\DeletePlanChange($processPlanChanges));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans('process.plan_changes')]))->success();
            return redirect()->route('process.showPlanChanges', [$processPlanChanges->process_id, $page]);
        } else {
            flash($response['message'])->error();
            return redirect()->route('process.showPlanChanges', [$processPlanChanges->process_id, $page]);
        }
    }
}
