<?php

namespace App\Http\Livewire\Admin\Catalogs\Units;

use App\Jobs\Indicators\Units\CreateUnitIndicator;
use App\Jobs\Indicators\Units\UpdateUnitIndicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class EditUnit extends Component
{
    use Jobs;

    public $unit;
    public $unitId;
    public $name;
    public $abbreviation;
    public $is_for_people=false;

    protected $listeners = ['openUnit'];

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('indicator_units')->ignore($this->unitId)],
            'abbreviation' => ['required', Rule::unique('indicator_units')->ignore($this->unitId)],
            'is_for_people' => ['nullable'],
        ];
    }

    public function openUnit($id)
    {
        $this->unit = IndicatorUnits::find($id);
        $this->unitId = $id;
        $this->name = $this->unit->name;
        $this->abbreviation = $this->unit->abbreviation;
        $this->is_for_people = $this->unit->is_for_people;
    }

    public function render()
    {
        return view('livewire.admin.catalogs.units.edit-unit');
    }

    public function save()
    {
        $data = $this->validate();
        $response = $this->ajaxDispatch(new UpdateUnitIndicator($data, $this->unitId));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.units', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleUpdateUnit');
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
