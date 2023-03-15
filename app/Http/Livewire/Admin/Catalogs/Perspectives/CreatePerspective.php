<?php

namespace App\Http\Livewire\Admin\Catalogs\Perspectives;

use App\Jobs\Indicators\Units\CreateUnitIndicator;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class CreatePerspective extends Component
{
    use Jobs;

    public $name;

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('perspectives')],
        ];
    }
    public function render()
    {
        return view('livewire.admin.catalogs.perspectives.create-perspective');
    }
    public function save(){
        $data=$this->validate();
        $response = $this->ajaxDispatch(new \App\Jobs\Admin\CreatePerspective($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.perspective', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreatePerspective');
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
        ]);
        $this->emit('perspectiveCreated');
    }

}
