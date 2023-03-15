<?php

namespace App\Http\Livewire\Process\PlanChanges;

use App\Models\Auth\User;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateChanges extends Component
{
    use Jobs;

    public $date;
    public $code;
    public $description;
    public $objective;
    public $consequence;
    public $process;
    public $processId;

    public function rules()
    {
        return [
            'code' => [
                'required',
                'max:5',
                'alpha_num',
                'alpha_dash',
                Rule::unique('process_plan_changes')
                    ->where('process_id', $this->processId)
                    ->where('deleted_at', null)
            ],
            'date' => 'required|date',
            'description' => 'required|max:500',
            'objective' => 'required|max:500',
            'consequence' => 'required|max:500',
        ];
    }

    public function mount(int $processId)
    {
        $this->process = Process::find($processId);
        $this->processId = $processId;
    }

    public function render()
    {
        return view('livewire.process.planChanges.create-changes');
    }

    public function save()
    {
        $data = $this->validate();
        $data += [
            'process_id' => $this->process->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Process\CreatePlanChange($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('process.plan_changes')]))->success()->livewire($this);
            self::resetForm();
            $this->emit('toggleCreateChange');
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
            'objective',
            'consequence',
        ]);
        $this->emit('planChangeCreated');
    }
}
