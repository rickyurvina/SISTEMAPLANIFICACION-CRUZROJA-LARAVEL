<?php

namespace App\Http\Livewire\Process\NonConformities\Actions;

use App\Abstracts\TableComponent;
use App\Models\Process\NonConformities;
use App\Models\Process\NonConformitiesActions;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use function view;

class NonConformityActionsIndex extends TableComponent
{
    use  Jobs;

    public $nonConformity;
    public $search = '';

    protected $listeners = [
        'actionCreated' => 'render',
        'updatedAction'=>'render',
        'formClosed'=>'render'
        ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function mount(int $nonConformityId)
    {
        $this->nonConformity = NonConformities::find($nonConformityId);
    }

    public function render()
    {
        $actions = NonConformitiesActions::with(['responsible', 'comments'])->where('processes_non_conformities_id', $this->nonConformity->id)
            ->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })
            ->when($this->search, function ($query) {
                $query->where(function ($q){
                    $q->where('name', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('implantation_date', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('status', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('start_date', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('end_date', 'iLIKE', '%' . $this->search . '%');
                });
            })
            ->paginate(setting('default.list_limit', '25'));;
        return view('livewire.process.non-conformities.actions.non-conformity-actions-index', compact('actions'));
    }

    public function deleteAction(int $id)
    {
        $action = NonConformitiesActions::find($id);
        try {
            DB::beginTransaction();
            $action->delete();
            DB::commit();
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans('general.action')]))->success()->livewire($this);
        } catch (\Exception $exception) {
            DB::rollback();
            flash($exception)->error()->livewire($this);
        }
    }
}

