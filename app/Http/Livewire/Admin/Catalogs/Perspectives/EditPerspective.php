<?php

namespace App\Http\Livewire\Admin\Catalogs\Perspectives;

use App\Jobs\Admin\UpdatePerspective;
use App\Jobs\Indicators\Units\UpdateUnitIndicator;
use App\Models\Admin\Perspective;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class EditPerspective extends Component
{
    use Jobs;

    public $perspectiveId;
    public $name;
    public $perspective;

    protected $listeners=['openPerspective'];
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('perspectives')->ignore($this->perspectiveId)],
        ];
    }
    public function openPerspective($id){
        $this->perspective = Perspective::find($id);
        $this->perspectiveId = $id;
        $this->name = $this->perspective->name;
    }
    public function render()
    {
        return view('livewire.admin.catalogs.perspectives.edit-perspective');
    }
    public function save()
    {
        $data = $this->validate();
        $response = $this->ajaxDispatch(new UpdatePerspective($data, $this->perspectiveId));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.perspective', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleUpdatePerspective');
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
