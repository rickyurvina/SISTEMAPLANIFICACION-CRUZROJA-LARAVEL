<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectFunder;
use App\Jobs\Projects\Catalogs\DeleteProjectFunder;
use App\Jobs\Projects\Catalogs\UpdateProjectFunder;
use App\Models\Projects\Catalogs\ProjectFunder;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectFounders extends Component
{
    use WithPagination, Jobs;

    /**
     * @var Builder|ProjectFunder
     */
    protected $projectFunders;
    /**
     * @var string
     */
    public string $code = '', $name = '', $type = '';
    /**
     * @var int
     */
    public int $project_funder_id = 0;
    /**
     * @var string
     */
    public string $search = '';

    /**
     * @var string
     */
    protected string $paginationTheme = 'bootstrap';

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|max:255',
        'code' => 'required|max:5|alpha_num|alpha_dash',
        'type' => 'present'
    ];

    /**
     * @var string[]
     */
    protected $listeners = ['cancel', 'delete', 'resetSession'];

    public function render()
    {
        $this->projectFunders = ProjectFunder::search('name', $this->search)->paginate(10);
        $projectFunders = $this->projectFunders;
        return view('livewire.projects.catalogs.project-funders.index', compact('projectFunders'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->code = '';
        $this->type = '';
    }

    public function store()
    {
        $validatedDate = $this->validate();

        $response = $this->ajaxDispatch(new CreateProjectFunder($validatedDate));
        if ($response['success']) {
            flash($response['message'])
                ->success()
                ->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->resetInputFields();

        $this->emit('projectFunderStore');

    }

    public function edit(ProjectFunder $model)
    {
        $this->project_funder_id = $model->id;
        $this->name = $model->name;
        $this->code = $model->code;
        $this->type = $model->type ?? '';
    }

    public function cancel()
    {
        $this->clearValidation();
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate();

        if ($this->project_funder_id) {
            $projectLineAction = ProjectFunder::find($this->project_funder_id);
            $newData = [
                'name' => $this->name,
                'code' => $this->code,
                'type' => $this->type,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectFunder($projectLineAction, $newData));
            if ($response['success']) {
                flash($response['message'])
                    ->success()
                    ->livewire($this);
            } else {
                flash($response['message'])->error()->livewire($this);
            }
            $this->resetInputFields();
            $this->emit('projectFunderStore');
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($id) {
            $response = $this->ajaxDispatch(new DeleteProjectFunder($id));
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
