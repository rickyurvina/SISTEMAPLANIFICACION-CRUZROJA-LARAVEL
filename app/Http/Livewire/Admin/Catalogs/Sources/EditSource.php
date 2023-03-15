<?php

namespace App\Http\Livewire\Admin\Catalogs\Sources;

use App\Jobs\Indicators\Sources\UpdateSource;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class EditSource extends Component
{
    use Jobs;
    public $source;
    public $sourceId;
    public $name;
    public $institution;
    public $description;
    public $type;

    protected $listeners=['openSource'];

    public function openSource($id){
        $this->source=IndicatorSource::find($id);
        $this->sourceId=$id;
        $this->name=$this->source->name;
        $this->institution=$this->source->institution;
        $this->description=$this->source->description;
        $this->type=$this->source->type;
    }

    public function rules(){
        return [
            'name' => ['required',Rule::unique('indicator_sources')->ignore($this->sourceId)],
            'institution' => ['required'],
            'type'=>'required',
        ];
    }

    public function render()
    {
        return view('livewire.admin.catalogs.sources.edit-source');
    }

    public function save(){
        $data=$this->validate();
        $response = $this->ajaxDispatch(new UpdateSource($data, $this->sourceId));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.module_process', 1)]))->success()->livewire($this);
            self::resetForm();
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
            'type',
            'description',
            'institution',
            'sourceId',
        ]);
        $this->emit('sourceCreated');
        $this->emit('toggleUpdateSource');
    }

}
