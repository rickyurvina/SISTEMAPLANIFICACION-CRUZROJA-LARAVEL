<?php

namespace App\Http\Livewire\Poa;

use App\Jobs\Poa\UpdatePoa;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Poa\Poa;
use App\Traits\Jobs;
use Livewire\Component;

class PoaEdit extends Component
{
    use Jobs;

    public $poaId;
    public $poa;

    public $poaReviewed;

    public $departments = [];
    public $existingDepartments = [];
    public $departmentsSelect = [];
    public $aux = [];

    protected $listeners = [
        'loadForm',
        'setToXApproveState',
    ];

    public function render()
    {
        $users = User::get();
        return view('livewire.poa.poa-edit', compact('users'));
    }

    public function loadForm($id)
    {
        $this->poaId = $id;
        if (user()->can('poa-view-all-poas')) {
            $this->poa = Poa::withoutGlobalScopes()->find($this->poaId);
        } else {
            $this->poa = Poa::find($this->poaId);
        }
        $this->poaReviewed = $this->poa->reviewed;
        $this->departments = Department::all();
        if (isset($this->poa->departments)) {
            $this->aux = $this->poa->departments->pluck('id')->toArray();
        }
        foreach ($this->departments as $item) {
            $element = [];
            $element['id'] = $item->id;
            $element['name'] = $item->name;
            if (in_array($item->id, $this->aux)) {
                $element['selected'] = true;
            }
            array_push($this->existingDepartments, $element);
        }
        $this->emit('refreshDropdown');
    }

    public function resetModal()
    {
        $this->reset();
        return redirect()->route('poa.poas', $this->poaId);
    }

    /**
     * Update reviewed state
     *
     */
    public function reviewed()
    {
        $this->poa->reviewed = $this->poaReviewed;
        $this->poa->save();
    }

    /**
     * Update departments selected
     *
     */
    public function updatedDepartmentsSelect()
    {
        $this->poa->departments()->sync($this->departmentsSelect);
        $this->existingDepartments = [];
        foreach ($this->departments as $item) {
            $element = [];
            $element['id'] = $item->id;
            $element['name'] = $item->name;
            if (in_array($item->id, $this->departmentsSelect)) {
                $element['selected'] = true;
            }
            array_push($this->existingDepartments, $element);
        }
        flash( trans_choice('messages.success.updated', 1, ['type' => __('poa.responsable_unit')]))->success()->livewire($this);
        $this->emit('refreshDropdown');
    }

}
