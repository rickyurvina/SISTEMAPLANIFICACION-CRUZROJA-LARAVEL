<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectLineActionServiceActivity;
use App\Jobs\Projects\Catalogs\DeleteProjectLineActionServiceActivity;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ListProjectLineActionServiceActivities extends Component
{
    use WithPagination, Jobs;


    /**
     * @var Collection|array
     */
    public $activities = [];

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
    protected $listeners = ['deleteActivity', 'cancel', 'editService' => 'mount'];

    public function mount($model)
    {
        $this->model = $model;
        $this->activities = [];
    }

    public function render()
    {
        if($this->model > 0){
            $this->activities = ProjectLineActionService::find($this->model)->lineActionActivities;
        }
        return view('livewire.projects.catalogs.project-line-action-service-activities.list');
    }


    /**
     * @param $id
     */
    public function deleteActivity($id)
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

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash',
        ]);
        $validated['description'] = '';
        $validated['service_id'] = $this->model;

        $response = $this->ajaxDispatch(new CreateProjectLineActionServiceActivity($validated));
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
