<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectLineActionService;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionService;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionServiceActivity;
use App\Jobs\Projects\Catalogs\UpdateProjectLineActionService;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProjectLineActionServices extends Component
{
    use  WithFileUploads, Uploads, WithPagination, Jobs;
    /**
     * @var Builder|ProjectLineActionService
     */
    protected $projectLineActionServices;
    /**
     * @var Builder|ProjectLineAction
     */
    protected $projectLineActions;
    /**
     * @var string
     */
    public string $code = '', $name = '', $description = '';
    /**
     * @var int
     */
    public int $project_line_action_service_id = 0;
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
     * @var Collection|array
     */
    public $activities = [];

    /**
     * @var string[]
     */

    public $media;

    protected $listeners = ['cancel', 'delete', 'resetSession'];

    public function render()
    {
        $this->projectLineActionServices = ProjectLineActionService::search('name', $this->search)->paginate(10);
        $projectLineActionServices = $this->projectLineActionServices;
        $this->projectLineActions = ProjectLineAction::all();
        $projectLineActions = $this->projectLineActions;
        return view('livewire.projects.catalogs.project-line-action-services.index',
            compact('projectLineActionServices', 'projectLineActions'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields(){
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->project_line_action_id = 0;
    }

    public function store()
    {
        $table = (new ProjectLineAction)->getTable();
        $validated = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'description' => 'present',
            'project_line_action_id' => "required|exists:$table,id"
        ]);
        $validated['prj_project_catalog_line_actions_id'] = $validated['project_line_action_id'];

        $response = $this->ajaxDispatch(new CreateProjectLineActionService($validated));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

        $this->emit('projectLineActionServiceStore');

    }

    public function edit($id)
    {
        $projectLineActionService = ProjectLineActionService::where('id',$id)->first();
        $this->project_line_action_service_id = $id;
        $this->name = $projectLineActionService->name;
        $this->code = $projectLineActionService->code;
        $this->project_line_action_id = $projectLineActionService->prj_project_catalog_line_actions_id;
        $this->description = $projectLineActionService->description ?? '';
        $this->activities =  $projectLineActionService->lineActionActivities;
        $projectLineActionService->loadMedia(['file']);
        $this->emit('editService', $id);

    }

    public function cancel()
    {
        $this->clearValidation();
        $this->resetInputFields();
        $this->emit('editService', 0);
    }

    public function update()
    {
        $table = (new ProjectLineAction)->getTable();
        $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash',
            'description' => 'present',
            'project_line_action_id' => "required|exists:$table,id"
        ]);

        if ($this->project_line_action_id) {
            $model = ProjectLineActionService::find($this->project_line_action_service_id);
            $newData = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'prj_project_catalog_line_actions_id' => $this->project_line_action_id,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectLineActionService($model, $newData));
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
     * @param $id
     */
    public function delete($id)
    {
        if($id){
            $response = $this->ajaxDispatch(new DeleteProjectLineActionService($id));
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
