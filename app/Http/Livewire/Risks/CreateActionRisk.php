<?php

namespace App\Http\Livewire\Risks;

use App\Jobs\Risk\RiskCreateAction;
use App\Jobs\Risk\RiskDeleteAction;
use App\Models\Auth\User;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Models\Risk\Risk;
use App\Models\Risk\RiskAction;
use App\Traits\Jobs;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use function config;
use function flash;
use function user;
use function view;

class CreateActionRisk extends Component
{

    use Jobs;

    public $risk;
    public $name;
    public $start_date;
    public $end_date;
    public $state;
    public $color;
    public $task_id;
    public $user_id;
    public $users;
    public $tasks;
    public array $status = [];
    public $model;
    public $modelId;
    public $class;
    public $type;

    protected $listeners = ['deleteAction', 'actionCreated' => '$refresh'];

    public function rules()
    {
        if ($this->class == Project::class) {
            return [
                'name' => 'required',
                'start_date' => 'required',
                'end_date' => 'required|after:start_date',
                'user_id' => 'required',
                'task_id' => 'required',
                'type' => 'required',
            ];
        } else {
            return [
                'name' => 'required',
                'start_date' => 'required',
                'end_date' => 'required|after:start_date',
                'user_id' => 'required',
            ];
        }

    }

    public function mount(Risk $risk, $modelId, $class)
    {
        $this->risk = $risk;
        $this->modelId = $modelId;
        $this->class = $class;
        $this->model = App::make($this->class)::withoutGlobalScope(\App\Scopes\Company::class)->find($this->modelId);
        if ($this->class == Project::class) {
            $this->tasks = Task::where('project_id', $this->model->id)->where('parent', '!=', 'root')->where('type', 'project')->get();
        }
        $this->users = User::get();
        $this->status =
            [
                RiskAction::OPEN => RiskAction::OPEN,
                RiskAction::CLOSED => RiskAction::CLOSED,
            ];
    }

    public function render()
    {
        $actions = RiskAction::where('risk_id', $this->risk->id)
            ->when(!(user()->hasRole('super-admin')), function ($q) {
                $q->where('user_id', user()->id);
            })->get();
        return view('livewire.risks.create-action-risk', compact('actions'));
    }

    public function saveAction()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'risk_id' => $this->risk->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'state' => RiskAction::OPEN,
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
            'type' => $this->type,
            'color' => config('constants.catalog.COLOR_PALETTE')[array_rand(config('constants.catalog.COLOR_PALETTE'), 1)],
        ];
        $response = $this->ajaxDispatch(new RiskCreateAction($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.action', 0)]))->success()->livewire($this);
            $this->reset(
                [
                    'name',
                    'user_id',
                    'task_id',
                    'start_date',
                    'end_date',
                    'type'
                ]
            );
//           $this->emitSelf('actionCreated');
        } else {
            flash($response['message'])->error()->livewire($this);
        }


    }

    public function deleteAction($payload)
    {
        $response = $this->ajaxDispatch(new RiskDeleteAction($payload));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.action', 0)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function generateDeleteAction($id)
    {
        $this->dispatchBrowserEvent('deleteAlertAction', ['id' => $id]);
    }

}
