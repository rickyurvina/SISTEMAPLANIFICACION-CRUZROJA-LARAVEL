<?php

namespace App\Http\Livewire\Projects\Catalogs;

use App\Jobs\Projects\Catalogs\CreateProjectAssistants;
use App\Jobs\Projects\Catalogs\CreateProjectRisksClassification;
use App\Jobs\Projects\Catalogs\DeleteProjectAssistant;
use App\Jobs\Projects\Catalogs\DeleteProjectRisksClassification;
use App\Jobs\Projects\Catalogs\UpdateProjectAssistant;
use App\Jobs\Projects\Catalogs\UpdateProjectRisksClassification;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectRiskClassification;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectRisksClassification extends Component
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
    public int $project_risk_classification = 0;
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
        $this->projectRisksClassification = ProjectRiskClassification::get();
        $projectRisksClassification = $this->projectRisksClassification;
        return view('livewire.projects.catalogs.project-risks-classification.index', compact('projectRisksClassification'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInputFields()
    {
        $this->name = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required|max:255',
        ]);

        $response = $this->ajaxDispatch(new CreateProjectRisksClassification($validatedDate));
        if ($response['success']) {
            $message = trans_choice('messages.success.added', 2, ['type' =>  trans('project.risks_classification')]);
            flash($message)->success();
        } else {
            flash($response['message'])->error();
        }
        $this->resetInputFields();
        return redirect()->route('risks_classification.index');
    }

    public function edit(ProjectRiskClassification $model)
    {
        $this->project_risk_classification = $model->id;
        $this->name = $model->name;
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
        ]);

        if ($this->project_risk_classification) {
            $newData = [
                'name' => $this->name,
            ];
            $response = $this->ajaxDispatch(new UpdateProjectRisksClassification($this->project_risk_classification, $newData));
            if ($response['success']) {
                $message = trans_choice('messages.success.updated', 2, ['type' =>  trans('project.risks_classification')]);
                flash($message)->success();
            } else {
                $message = $response['message'];
                flash($message)->error();
            }
            $this->resetInputFields();
            return redirect()->route('risks_classification.index');
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        if ($id) {
            $response = $this->ajaxDispatch(new DeleteProjectRisksClassification($id));
            if ($response['success']) {
                $message = trans_choice('messages.success.deleted', 2, ['type' =>  trans('project.risks_classification')]);
                flash($message)->success();
            } else {
                flash($response['message'])->error();
            }
            return redirect()->route('risks_classification.index');

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
