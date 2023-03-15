<?php

namespace App\Http\Livewire\Admin\Catalogs\Sources;

use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class CreateSource extends Component
{
    use Jobs;

    public $name;
    public $institution;
    public $description;
    public $type;

    public function rules(){
        return [
            'name' => ['required',Rule::unique('indicator_sources')],
            'institution' => ['required'],
            'type'=>'required',
        ];
    }

    public function render()
    {
        return view('livewire.admin.catalogs.sources.create-source');
    }

    public function save(){
        $data=$this->validate();
        $response = $this->ajaxDispatch(new \App\Jobs\Indicators\Sources\CreateSource($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.source', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreateSource');
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
            'description',
            'institution',
            'type',
        ]);
        $this->emit('sourceCreated');
    }
}
