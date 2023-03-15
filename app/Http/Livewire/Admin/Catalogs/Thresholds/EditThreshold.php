<?php

namespace App\Http\Livewire\Admin\Catalogs\Thresholds;

use App\Jobs\Indicators\Thresholds\UpdateThreshold;
use App\Models\Indicators\Threshold\Threshold;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class EditThreshold extends Component
{
    use Jobs;

    public $idThreshold;
    public $name;
    public $maxAD;
    public $minAW;
    public $maxAW;
    public $minAS;
    public $maxDD;
    public $minDW;
    public $maxDW;
    public $minDS;
    public $maxTD;
    public $minTW;
    public $maxTW;
    public $minTS;
    public $threshold;

    protected $listeners = ['openThreshold'];

    public function rules(){
        return [
            'name' => ['required', Rule::unique('thresholds')->ignore($this->idThreshold)],
        ];
    }

    public function openThreshold($id)
    {
        $this->idThreshold = $id;
        $this->threshold = Threshold::find($id);
        $this->name = $this->threshold->name;
        $this->maxAD = $this->threshold->properties[0][3];
        $this->minAW = $this->threshold->properties[1][3];
        $this->maxAW = $this->threshold->properties[2][3];
        $this->minAS = $this->threshold->properties[3][3];
        $this->maxDD = $this->threshold->properties[4][3];
        $this->minDW = $this->threshold->properties[5][3];
        $this->maxDW = $this->threshold->properties[6][3];
        $this->minDS = $this->threshold->properties[7][3];
        $this->maxTD = $this->threshold->properties[8][3];
        $this->minTW = $this->threshold->properties[9][3];
        $this->maxTW = $this->threshold->properties[10][3];
        $this->minTS = $this->threshold->properties[11][3];
    }

    public function render()
    {
        return view('livewire.admin.catalogs.thresholds.edit-threshold');
    }
    public function save()
    {
        $data = $this->validate();
        $data +=
            [
                'maxAD' => $this->maxAD,
                'minAW' => $this->minAW,
                'maxAW' => $this->maxAW,
                'minAS' => $this->minAS,
                'maxDD' => $this->maxDD,
                'minDW' => $this->minDW,
                'maxDW' => $this->maxDW,
                'minDS' => $this->minDS,
                'maxTD' => $this->maxTD,
                'minTW' => $this->minTW,
                'maxTW' => $this->maxTW,
                'minTS' => $this->minTS
            ];
        $response = $this->ajaxDispatch(new \App\Jobs\Indicators\Thresholds\UpdateThreshold($data, $this->idThreshold));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.source', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleUpdateThreshold');
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
            'maxAD',
            'minAW',
            'maxAW',
            'minAS',
            'maxDD',
            'minDW',
            'maxDW',
            'minDS',
            'maxTD',
            'minTW',
            'maxTW',
            'minTS'
        ]);
        $this->emit('thresholdCreated');
    }
    public function updated()
    {
        $this->maxAD = $this->minAW;
        $this->minAS = $this->maxAW;
        $this->maxDD = $this->minDW;
        $this->minDS = $this->maxDW;
        $this->maxTD = $this->minTW;
        $this->minTS = $this->maxTW;
    }
}
