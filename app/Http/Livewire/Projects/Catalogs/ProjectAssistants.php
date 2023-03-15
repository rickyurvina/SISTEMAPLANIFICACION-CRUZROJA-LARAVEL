<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectAssistants;
use App\Jobs\Projects\Catalogs\DeleteProjectAssistant;
use App\Jobs\Projects\Catalogs\UpdateProjectAssistant;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectAssistants extends Component
{
    use WithPagination, Jobs;

    /**
     * @var Builder|ProjectAssistant
     */
    protected $projectAssistants;
    /**
     * @var string
     */
    public string $code = '', $name = '';
    /**
     * @var int
     */
    public int $project_assistant_id = 0;
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
        $this->projectAssistants = ProjectAssistant::search('name', $this->search)->paginate(10);
        $projectAssistants = $this->projectAssistants;
        return view('livewire.projects.catalogs.project-assistants.index', compact('projectAssistants'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->code = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:5|alpha_num|alpha_dash'
        ]);

        $response = $this->ajaxDispatch(new CreateProjectAssistants($validatedDate));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

        $this->emit('projectAssistantStore');

    }

    public function edit(ProjectAssistant $model)
    {
        $this->project_assistant_id = $model->id;
        $this->name = $model->name;
        $this->code = $model->code;
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
        ]);

        if ($this->project_assistant_id) {
            $projectLineAction = ProjectAssistant::find($this->project_assistant_id);
            $newData = [
                'name' => $this->name,
                'code' => $this->code,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectAssistant($projectLineAction, $newData));
            if ($response['success']) {
                flash($response['message'])
                    ->success()
                    ->livewire($this);
            } else {
                flash($response['message'])->error()->livewire($this);
            }
            $this->resetInputFields();
            $this->emit('projectAssistantStore');
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($id) {
            $response = $this->ajaxDispatch(new DeleteProjectAssistant($id));
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
