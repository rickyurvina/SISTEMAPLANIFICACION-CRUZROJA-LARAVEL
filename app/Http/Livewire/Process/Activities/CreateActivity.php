<?php

namespace App\Http\Livewire\Process\Activities;

use App\Http\Livewire\Components\Modal;
use App\Models\Process\Catalogs\GeneratedService;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;

class CreateActivity extends Modal
{
    use Jobs;

    public $name;
    public $code;
    public $expected_result;
    public $generated_service_id;
    public $generated_services;
    public $specifications;
    public $cares;
    public $procedures;
    public $equipment;
    public $supplies;
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
                Rule::unique('process_activities')
                    ->where('process_id', $this->processId)
                    ->where('deleted_at', null)
            ],
            'name' => 'required|max:200',
            'expected_result' => 'required|max:500',
            'specifications' => 'max:500',
            'cares' => 'max:500',
            'procedures' => 'max:500',
            'equipment' => 'max:500',
            'supplies' => 'max:500',
        ];
    }

    public function mount(int $processId)
    {
        $this->generated_services = GeneratedService::all();
        $this->process = Process::find($processId);
        $this->processId = $processId;
    }

    public function render()
    {
        return view('livewire.process.activities.create-activity');
    }

    public function submitActivity()
    {
        $data = $this->validate();
        $data += [
            'code' => $this->code,
            'name' => $this->name,
            'expected_result' => $this->expected_result,
            'specifications' => $this->specifications,
            'cares' => $this->cares,
            'procedures' => $this->procedures,
            'equipment' => $this->equipment,
            'supplies' => $this->supplies,
            'generated_service_id' =>  $this->generated_service_id,
            'process_id' => $this->process->id,
            'company_id' => session('company_id'),
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Process\CreateActivity($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.activity', 1)]))->success()->livewire($this);
            $this->emit('toggleCreateActivity');
            $this->emit('activityCreated');
            self::resetForm();
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['name', 'code', 'expected_result', 'specifications', 'cares', 'procedures', 'equipment', 'supplies','generated_service_id']);
    }
}
