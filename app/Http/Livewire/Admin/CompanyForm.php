<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Company;
use App\Traits\Jobs;
use Hoa\Compiler\Llk\Rule\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\Admin\CreateCompany;

class CompanyForm extends Component
{
    use WithFileUploads, Jobs;

    public $name = '';
    public $identification = '';
    public $phone = '';
    public $fax = '';
    public $parent;
    public $webSite = '';
    public $photo;
    public $description = '';
    public $level;

    public function rules()
    {
        return
            [
                'name' => 'required',
                'identification' => 'required|max:13|min:13|unique:settings,value',
                'level' => 'required',
                'parent' => 'required'
            ];
    }

    public function render()
    {
        $list_parents = [];
        if ($this->level > 1) {
            $list_parents = Company::getParents($this->level);
        }
        $levels = config('constants.catalog.LEVELS');
        return view('livewire.admin.company-form', compact('levels', 'list_parents'));
    }

    public function submit()
    {
        $this->validate();
        $data = [
            'currency' => 'USD',
            'enabled' => '1',
            'name' => $this->name,
            'domain' => '',
            'identification' => $this->identification,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'level' => $this->level,
            'web_site' => $this->webSite,
            'description' => $this->description,
            'parent_id' => $this->parent
        ];

        $response = $this->ajaxDispatch(new CreateCompany($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.companies', 1)]))->success();
            return redirect(route('companies.index'));
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}