<?php

namespace App\Http\Livewire\Process\Catalogs;

use App\Http\Requests\StoreGeneratedServiceRequest;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateGeneratedService extends Component
{
    use Jobs;

    public $code;
    public $name;
    public $description;

    public function render()
    {
        return view('livewire.process.catalogs.create-generated-service');
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                'max:5',
                'alpha_num',
                'alpha_dash',
                Rule::unique('generated_services')
                    ->where('deleted_at', null)
            ],
            'name' => 'required|max:200',
            'description' => 'required|max:500',
        ];
    }

    public function store()
    {
        $request = $this->validate();
        $response = $this->ajaxDispatch(new \App\Jobs\Process\Catalogs\GeneratedServices\CreateGeneratedService($request));
        if ($response['success']) {
            $this->resetInputFields();
            $this->emit('serviceCreated');
            $this->emit('toggleCreatedService');
            flash(trans_choice('messages.success.added', 1, ['type' => trans('general.generated_service')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function resetInputFields()
    {
        $this->resetValidation();
        $this->reset('name','code','description');
    }
}
