<?php

namespace App\Http\Livewire\Process\PlanChanges\ChangesActivities;

use App\Models\Auth\User;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateChangesActivities extends Component
{
    use Jobs;

    public $changeId;
    public $code;
    public $name;
    public $user_id;
    public $description;
    public $start_date;
    public $end_date;
    public $users;

    public function rules()
    {
        return [
            'code' => [
                'required',
                'max:5',
                'alpha_num',
                'alpha_dash',
                Rule::unique('process_plan_changes_activities')
                    ->where('process_plan_changes_id', $this->changeId)
                    ->where('deleted_at', null)
            ],
            'name' => 'required|max:200',
            'description' => 'required|max:500',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
            'user_id' => 'required'
        ];
    }

    public function mount($changeId)
    {
        $this->changeId = $changeId;
        $this->users = User::get();
    }

    public function render()
    {
        return view('livewire.process.planChanges.changesActivities.create-changes-activities');
    }

    public function save()
    {
        $data = $this->validate();
        $data += [
            'process_plan_changes_id' => $this->changeId,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Process\CreateChangeActivity($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('general.activity')]))->success()->livewire($this);
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
            'code',
            'name',
            'user_id',
            'description',
            'start_date',
            'end_date',
        ]);
        $this->emit('activityCreated');
        $this->emit('toggleCreateActivity');
    }

    public function cancelForm()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset([
            'code',
            'name',
            'user_id',
            'description',
            'start_date',
            'end_date',
        ]);
    }
}
