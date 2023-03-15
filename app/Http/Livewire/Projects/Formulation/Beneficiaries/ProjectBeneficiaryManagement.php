<?php

namespace App\Http\Livewire\Projects\Formulation\Beneficiaries;


use App\Jobs\Projects\CreateProjectBeneficiaries;
use App\Models\Common\Catalog;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectBeneficiaries;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectBeneficiaryManagement extends Component
{
    use Jobs;

    public int $projectId;

    public $beneficiaries;
    public $beneficiary_types;

    public $projectType;
    public $projectBeneficiary;
    public $projectAmount;

    public $project;
    public $messages;


    protected $listeners = [
        'beneficiaryUpdated' => 'render',
    ];


    public function mount($id, Project $project, $messages=null)
    {
        $this->projectId = $id;
        $this->beneficiaries = Catalog::catalogName('beneficiaries')->first()->details;
        $this->beneficiary_types = Catalog::catalogName('project_beneficiary_types')->first()->details;
        $this->project = $project;
        $this->messages=$messages;

    }

    public function submit()
    {
        $this->validate();

        $data = [
            'project_id' => $this->projectId,
            'type_id' => $this->projectType,
            'beneficiary_id' => $this->projectBeneficiary,
            'amount' => $this->projectAmount,
            'company_id' => session('company_id')
        ];

        $response = $this->ajaxDispatch(new CreateProjectBeneficiaries($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.poa_activity_beneficiaries', 1)]))->success()->livewire($this);
            $this->reset(
                [
                    'type_id',
                    'amount'
                ]
            );
        } else {
            flash($response['message'])->error()->livewire($this);
        }

    }

    public function delete($id)
    {
        ProjectBeneficiaries::find($id)->delete();
        flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.poa_activity_beneficiaries', 1)]))->success()->livewire($this);
    }

    public function render()
    {
        $catalogs_types = Catalog::catalogName('project_beneficiary_types')->first()->details;
        $catalogs_beneficiaries = Catalog::catalogName('beneficiaries')->first()->details;
        $project_beneficiaries = ProjectBeneficiaries::with(['types', 'beneficiaries'])->orderBy('type_id', 'ASC')->where('project_id', $this->projectId)->get();
        return view('livewire.projects.formulation.beneficiaries.project-beneficiary-management',
            compact('project_beneficiaries', 'catalogs_types', 'catalogs_beneficiaries'));
    }
}
