<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectLineActionService;
use App\Jobs\Projects\Catalogs\CreateProjectLineActionServiceActivity;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionService;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionServiceActivity;
use App\Jobs\Projects\Catalogs\UpdateProjectLineActionService;
use App\Jobs\Projects\Catalogs\UpdateProjectLineActionServiceActivity;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Models\Projects\Catalogs\ProjectLineActionServiceActivity;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectLineActionServiceActivities extends Component
{
    use WithPagination, Jobs;

    /**
     * @var Builder|ProjectLineActionServiceActivity
     */
    protected $activities;

    /**
     * @var Builder|ProjectLineActionService
     */
    protected $services;

    /**
     * @var string
     */
    public string $code = '', $name = '', $description = '';

    /**
     * @var int
     */
    public int $service_id = 0;

    /**
     * @var int
     */
    public int $activity_id = 0;

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

    public function rules()
    {
        $table = (new ProjectLineActionService())->getTable();

        return
            [
                'code' => [
                    'required',
                    'max:5',
                    'alpha_num',
                    'alpha_dash',
                    Rule::unique('prj_project_catalog_line_action_service_activities')->where('service_id', $this->service_id)
                        ->where('deleted_at', null)
                    ->ignore($this->activity_id)
                ],
                'name' => 'required|max:500|min:3',
                'description' => 'present',
                'service_id' => "required|exists:$table,id"
            ];
    }

    public function render()
    {
        $this->activities = ProjectLineActionServiceActivity::search('name', $this->search)->paginate(10);
        $activities = $this->activities;
        $this->services = ProjectLineActionService::all();
        $services = $this->services;

        return view('livewire.projects.catalogs.project-line-action-service-activities.index',
            compact('activities', 'services'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields(){
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->service_id = 0;
    }

    public function store()
    {
        $validated = $this->validate();

        $response = $this->ajaxDispatch(new CreateProjectLineActionServiceActivity($validated));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

        $this->emit('projectLineActionServiceActivityStore');

    }

    public function edit($id)
    {
        $model = ProjectLineActionServiceActivity::where('id',$id)->first();
        $this->activity_id = $id;
        $this->name = $model->name;
        $this->code = $model->code;
        $this->service_id = $model->service_id;
        $this->description = $model->description ?? '';

    }

    public function cancel()
    {
        $this->clearValidation();
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate();

        if ($this->service_id) {
            $model = ProjectLineActionServiceActivity::find($this->activity_id);
            $newData = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'service_id' => $this->service_id,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectLineActionServiceActivity($model, $newData));
            if ($response['success']) {
                flash($response['message'])
                    ->success()
                    ->livewire($this);
            } else {
                flash($response['message'])->error()->livewire($this);
            }
            $this->resetInputFields();
            $this->emit('projectLineActionServiceActivityStore');
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        if($id){
            $response = $this->ajaxDispatch(new DeleteProjectLineActionServiceActivity($id));

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
