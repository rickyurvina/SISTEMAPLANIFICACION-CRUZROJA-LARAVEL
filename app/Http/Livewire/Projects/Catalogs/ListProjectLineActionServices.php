<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectLineActionService;
use App\Jobs\Projects\Catalogs\CreateProjectLineActionServiceActivity;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionService;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionServiceActivity;
use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ListProjectLineActionServices extends Component
{
    use WithPagination, Jobs;


    /**
     * @var Collection|array
     */
    public $services = [];

    /**
     * @var int
     */
    public int $model;

    /**
     * @var string
     */
    public string $code = '', $name = '';

    /**
     * @var string[]
     */
    protected $listeners = ['deleteService', 'cancel', 'editLineAction' => 'mount'];

    public function mount($model)
    {
        $this->model = $model;
        $this->services = [];
    }

    public function render()
    {
        if($this->model > 0){
            $this->services = ProjectLineAction::find($this->model)->services;
        }
        return view('livewire.projects.catalogs.project-line-action-services.list');
    }


    /**
     * @param $id
     */
    public function deleteService($id)
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

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash',
        ]);
        $validated['description'] = '';
        $validated['prj_project_catalog_line_actions_id'] = $this->model;

        $response = $this->ajaxDispatch(new CreateProjectLineActionService($validated));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

    }
    public function cancel()
    {
        $this->clearValidation();
        $this->resetInputFields();
    }

    /**
     *
     */
    private function resetInputFields(){
        $this->name = '';
        $this->code = '';
    }

}
