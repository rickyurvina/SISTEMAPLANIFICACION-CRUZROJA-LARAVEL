<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Admin\UpdateCompany;
use App\Models\Admin\Company;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyEdit extends Component
{
    public $idCompany;

    use WithFileUploads;

    public $name;
    public $identification;
    public $phone;
    public $fax;
    public $parent;
    public $webSite;
    public $photo;
    public $description;
    public $level;

    protected $rules = [
        'name' => 'required',
        'identification' => 'required|max:13|min:13'
    ];

    public function render()
    {
        $company = Company::findOrFail($this->idCompany);

        $this->name = $company->name;
        $this->identification = $company->identification;
        $this->phone = $company->phone;
        $this->fax = $company->fax;
        $this->parent = $company->parent_id;
        $this->webSite = $company->web_site;
        $this->level = $company->level;
        $this->description = $company->description;

        $list_parents = [];

        if ($this->level > 1) {
            $list_parents = Company::getParents($this->level);
        }

        $levels = config('constants.catalog.LEVELS');
        return view('livewire.admin.company-form', compact('levels', 'list_parents', 'company'));
    }

    public function submit()
    {
        $this->validate([
            'webSite' => ['nullable','regex:/^((?=^.{4,253}$)(((http){0,1}|(http){0,1}|(ftp){0,1}|(ws){0,1})(s{0,1}):\/\/){0,1})((((?!-)[\pL0-9\-]{1,63})(?<!-)(\.)){1,})(((?!-)[a-z0-9\-]{1,63})(?<!-)((\/{0,1}[\pL\pN?=\-]*)+){1})$/']
        ]);

        dispatch_now(new UpdateCompany([
            'id' => $this->idCompany,
            'name' => $this->name,
            'identification' => $this->identification,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'level' => $this->level,
            'web_site' => $this->webSite,
            'description' => $this->description,
            'parent_id' => $this->parent
        ]));

        flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.companies', 0)]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }
}