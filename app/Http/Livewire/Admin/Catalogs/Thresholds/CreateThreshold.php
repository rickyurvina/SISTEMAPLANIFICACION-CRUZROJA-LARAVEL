<?php

namespace App\Http\Livewire\Admin\Catalogs\Thresholds;

use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class CreateThreshold extends Component
{
    use Jobs;

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

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('thresholds')],
        ];
    }

    public function render()
    {
        return view('livewire.admin.catalogs.thresholds.create-threshold');
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
        $response = $this->ajaxDispatch(new \App\Jobs\Indicators\Thresholds\CreateThreshold($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.source', 1)]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreateThreshold');
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
