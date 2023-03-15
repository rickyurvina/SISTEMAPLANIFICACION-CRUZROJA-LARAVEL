<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectLineAction;
use App\Jobs\Projects\Catalogs\CreateProjectLineActionService;
use App\Jobs\Projects\Catalogs\UpdateProjectLineAction;
use App\Jobs\Projects\Catalogs\DeleteProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Strategy\PlanDetail;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectLineActions extends Component
{
    use WithPagination, Jobs;

    /**
     * @var Builder|ProjectLineAction
     */


    /**
     * @var string
     */
    public string $code = '', $name = '', $description = '', $plan_detail_id='';

    /**
     * @var int
     */
    public int $project_line_action_id = 0;

    /**
     * @var string
     */
    public string $search = '';

    /**
     * @var string
     */
    protected string $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['cancel', 'delete', 'resetSession'];

    public function render()
    {

        $projectLineActions =ProjectLineAction::search('name', $this->search)->paginate(10);
        $programs=PlanRegisteredTemplateDetails::with('planDetails')->where('program',true)->first()->planDetails;
        return view('livewire.projects.catalogs.project-line-actions.index', compact('projectLineActions','programs'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->plan_detail_id = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash',
            'description' => 'present',
            'plan_detail_id' => 'required',
        ]);

        $response = $this->ajaxDispatch(new CreateProjectLineAction($validatedDate));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

        $this->emit('projectLineActionStore');

    }

    public function edit(ProjectLineAction $model)
    {
        $this->project_line_action_id = $model->id;
        $this->name = $model->name;
        $this->code = $model->code;
        $this->description = $model->description ?? '';
        $this->plan_detail_id = $model->plan_detail_id ?? '';
        $this->emit('editLineAction', $model->id);
    }

    public function cancel()
    {
        $this->clearValidation();
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash',
            'plan_detail_id' => 'required',
        ]);

        if ($this->project_line_action_id) {
            $projectLineAction = ProjectLineAction::find($this->project_line_action_id);
            $newData = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'plan_detail_id' => $this->plan_detail_id,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectLineAction($projectLineAction, $newData));
            if ($response['success']) {
                flash($response['message'])
                    ->success()
                    ->livewire($this);
            } else {
                flash($response['message'])->error()->livewire($this);
            }
            $this->resetInputFields();
            $this->emit('projectLineActionStore');
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($id) {
            $response = $this->ajaxDispatch(new DeleteProjectLineAction($id));
            if ($response['success']) {
                flash($response['message'])
                    ->success()
                    ->livewire($this);
            } else {
                flash($response['message'])->error()->livewire($this);
            }
        }
    }

    /**
     *
     */
    public function resetSession()
    {
        session()->forget('success');
    }
}
