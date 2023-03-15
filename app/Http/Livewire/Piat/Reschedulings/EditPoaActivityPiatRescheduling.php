<?php

namespace App\Http\Livewire\Piat\Reschedulings;

use App\Models\Poa\Piat\PoaActivityPiat;
use App\Traits\Jobs;
use Livewire\Component;
use function flash;
use function redirect;
use function user;
use function view;

class EditPoaActivityPiatRescheduling extends Component
{
    use Jobs;

    public $description;
    public $status;
    public $approvedId;
    public $activity;
    public $rescheduling;

    protected $listeners = ['openEditRescheduling'];

    public function openEditRescheduling(int $id)
    {
        $this->rescheduling = \App\Models\Poa\Piat\PoaActivityPiatRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->status = $this->rescheduling->status;
    }

    public function mount(int $piatId)
    {
        $this->activity=PoaActivityPiat::find($piatId);
    }

    public function render()
    {
        return view('livewire.piat.reschedulings.edit-poa-activity-piat-rescheduling');
    }

    public function resetForm()
    {
        $this->reset([
            'description',
            'status',
        ]);
    }

    public function edit()
    {
        $data = $this->validate([
            'description' => 'required',
        ]);
        $data += [
            'id' => $this->rescheduling->id,
            'description' => $this->description,
            'status' => \App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUS_OPENED,
            'poa_activity_piat_id' => $this->activity->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Poa\PoaPiatActivityEditRescheduling($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.rescheduling', 0)]))->success();
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }
        return redirect()->route('piat.piat_rescheduling', $this->activity->id);
    }

}
