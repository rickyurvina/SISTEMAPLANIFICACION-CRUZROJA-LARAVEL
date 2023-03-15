<?php

namespace App\Http\Livewire\Process\NonConformities;

use App\Models\Process\NonConformities;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateNonConformities extends Component
{
    use Jobs;

    public $process;
    public $number;
    public $code;
    public $description;
    public $date;
    public $evidence;
    public $type;
    public $causes = [];

    protected $listeners = ['causesAdded'];


    public function rules()
    {
        return [
            'code' => [
                'required',
                'max:5',
                'alpha_num',
                'alpha_dash',
                Rule::unique('processes_non_conformities')
                    ->where('process_id', $this->process->id)
                    ->where('deleted_at', null)
            ],
            'number' => 'required',
            'description' => 'required|max:500',
            'evidence' => 'required|max:500',
            'type' => 'required',
        ];
    }

    public function mount($processId)
    {
        $this->process = Process::find($processId);
    }

    public function render()
    {
        return view('livewire.process.non-conformities.create-non-conformities');
    }

    public function save()
    {
        $data = $this->validate();
        $data += [
            'process_id' => $this->process->id,
            'code' => $this->code,
            'number' => $this->number,
            'type' => $this->type,
            'description' => $this->description,
            'date' => now(),
            'evidence' => $this->evidence,
            'closing_verification' => false,
            'efficiency_verification' => false,
            'causes' => $this->causes,
            'state' => NonConformities::TYPE_OPEN,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Process\CreateNonConformity($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('general.nonconformity')]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreateNonConformity');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset([
            'code',
            'date',
            'description',
            'evidence',
            'type',
            'number',
            'causes',
        ]);
        $this->emit('nonConformityCreated');
    }

    public function causesAdded($elements)
    {
        $data=[];
        foreach ($elements as $element) {
            $item = mb_strtoupper($element);
            array_push($data, $item);
        }
        $this->causes = $data;
    }
}
