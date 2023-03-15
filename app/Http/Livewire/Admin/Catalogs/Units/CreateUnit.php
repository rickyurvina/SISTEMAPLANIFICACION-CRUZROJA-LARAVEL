<?php

namespace App\Http\Livewire\Admin\Catalogs\Units;

use App\Jobs\Indicators\Units\CreateUnitIndicator;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class CreateUnit extends Component
{
    use Jobs;

    public $name;
    public $abbreviation;
    public $is_for_people=false;

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('indicator_units')],
            'abbreviation' => ['required', Rule::unique('indicator_units')],
            'is_for_people' => ['nullable'],
        ];
    }

    public function render()
    {
        return view('livewire.admin.catalogs.units.create-unit');
    }

    public function save(){
        $data=$this->validate();
        $response = $this->ajaxDispatch(new CreateUnitIndicator($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.units', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreateUnit');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
    public function resetForm()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset([
            'name',
            'abbreviation',
            'is_for_people',
        ]);
        $this->emit('unitCreated');
    }

}
