<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Company;
use Livewire\Component;

class DaughterInstitutionsForm extends Component
{
    public $idCompany;

    public function render()
    {
        $companies = Company::where('parent_id', $this->idCompany)->get();
        return view('livewire.admin.daughter-institutions-form', compact('companies'), ['company' => $this->idCompany]);
    }
}