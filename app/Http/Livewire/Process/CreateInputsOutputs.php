<?php

namespace App\Http\Livewire\Process;

use App\Jobs\Process\CreateProcessInputs;
use App\Jobs\Process\CreateProcessOutputs;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Livewire\Component;

class CreateInputsOutputs extends Component
{
    use Jobs;
    public $process;
    public $inputs = [];
    public $outputs = [];
    public $inputsItems = [];
    public $outputsItems = [];
    protected $listeners = ['inputsAdded','outputsAdded'];

    public function mount($processId)
    {
        $this->process=Process::find($processId);
        $this->inputsItems=$this->process->inputs;
        $this->outputsItems=$this->process->outputs;
    }

    public function render()
    {
        return view('livewire.process.create-inputs-outputs');
    }
    public function inputsAdded($elements)
    {
        $data=[];
        foreach ($elements as $element) {
            $item = mb_strtoupper($element);
            array_push($data, $item);
        }
        $this->inputs = $data;
        $response = $this->ajaxDispatch(new CreateProcessInputs($data,$this->process->id));
        if ($response['success']) {
            $message = trans_choice('messages.success.updated', 1, ['type' => trans('general.inputs')]);
            flash($message)->success()->livewire($this);
        } else {
            $message = $response['message'];
            flash($message)->error()->livewire($this);
        }
    }

    public function outputsAdded($elements)
    {
        $data=[];
        foreach ($elements as $element) {
            $item = mb_strtoupper($element);
            array_push($data, $item);
        }
        $this->inputs = $data;
        $response = $this->ajaxDispatch(new CreateProcessOutputs($data,$this->process->id));
        if ($response['success']) {
            $message = trans_choice('messages.success.updated', 1, ['type' => trans('general.outputs')]);
            flash($message)->success()->livewire($this);
        } else {
            $message = $response['message'];
            flash($message)->error()->livewire($this);
        }
    }
}
