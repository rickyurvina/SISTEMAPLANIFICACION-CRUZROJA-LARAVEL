<?php

namespace App\Http\Livewire\Projects\Formulation\Beneficiaries;

use App\Jobs\Projects\CreateProjectBeneficiaries;
use App\Models\Common\Catalog;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectBeneficiaryCreate extends Component
{
    use Jobs;

    public int $projectId;

    public $beneficiaries;
    public $beneficiary_types;

    public $projectType='';
    public $projectBeneficiary;
    public $projectAmount;

    protected $rules = [
        'projectType' => 'required',
        'projectAmount' => 'required|numeric',
    ];

    public function mount($id)
    {
        $this->projectId = $id;
        $this->beneficiaries = Catalog::catalogName('beneficiaries')->first()->details;
        $this->beneficiary_types = Catalog::catalogName('project_beneficiary_types')->first()->details;
    }

    public function render()
    {
        return view('livewire.projects.formulation.beneficiaries.project-beneficiary-create');
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
        } else {
            flash($response['message'])->error()->livewire($this);
        }
        $this->clean();
        $this->emit('beneficiaryUpdated');
        $this->emit('togglePublicBeneficiaryAddModal');
        $this->resetForm();
    }

    public function clean()
    {
        $this->projectType = '';
        $this->projectBeneficiary = 0;
        $this->projectAmount = "";
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('togglePublicBeneficiaryAddModal');
    }

    public function resetForm()
    {
        $this->projectType='';
        $this->resetErrorBag();
        $this->resetValidation();
    }

}
