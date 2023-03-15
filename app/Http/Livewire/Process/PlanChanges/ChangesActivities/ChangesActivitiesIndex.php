<?php

namespace App\Http\Livewire\Process\PlanChanges\ChangesActivities;

use App\Abstracts\TableComponent;
use App\Models\Process\ChangesActivities;
use App\Models\Process\ProcessPlanChanges;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;

class ChangesActivitiesIndex extends TableComponent
{
    use  Jobs;

    public $processPlanChanges;
    public $search = '';

    protected $listeners = ['activityCreated' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function mount(int $changeId)
    {
        $this->processPlanChanges = ProcessPlanChanges::find($changeId);
    }

    public function render()
    {
        $activities = ChangesActivities::with(['responsible', 'comments'])->where('process_plan_changes_id', $this->processPlanChanges->id)->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })
            ->when($this->search, function ($query) {
                $query->where('code', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('name', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('description', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('start_date', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('end_date', 'iLIKE', '%' . $this->search . '%');
            })
            ->paginate(setting('default.list_limit', '25'));
        return view('livewire.process.planChanges.changesActivities.changes-activities-index', compact('activities'));
    }

    public function deleteActivity(int $id)
    {
        $activity=ChangesActivities::find($id);
        try {
            DB::beginTransaction();
            $activity->delete();
            DB::commit();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans('process.activity')]))->success()->livewire($this);
        } catch (Exception $exception) {
            DB::rollback();
            flash($exception)->error()->livewire($this);
        }
    }
}
