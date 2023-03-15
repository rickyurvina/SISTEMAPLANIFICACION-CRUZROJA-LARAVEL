<?php

namespace App\Http\Livewire\Piat\Reschedulings;

use App\Models\Auth\User;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Traits\Jobs;
use Livewire\Component;
use function __;
use function flash;
use function redirect;
use function route;
use function trans;
use function user;
use function view;

class ApprovePoaActivityPiatRescheduling extends Component
{
    use Jobs;

    public $description;
    public $status;
    public $approvedId;
    public $activity;
    public $rescheduling;

    protected $listeners = ['openApproveRescheduling'];

    public function openApproveRescheduling(int $id)
    {
        $this->rescheduling = \App\Models\Poa\Piat\PoaActivityPiatRescheduling::find($id);
        $this->description = $this->rescheduling->description;
        $this->activity = PoaActivityPiat::find($this->rescheduling->poa_activity_piat_id);
    }

    public function render()
    {
        return view('livewire.piat.reschedulings.approve-poa-activity-piat-rescheduling');
    }

    public function approve()
    {
        $this->rescheduling->status = \App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUS_APPROVED;
        $this->rescheduling->approved_id = user()->id;
        $this->rescheduling->save();
        $this->activity->is_terminated = false;
        $this->activity->save();
        flash('Aprobado satisfactoriamente')->success();
        $notificationArray = [];
        $solicitant = User::find($this->rescheduling->user_id);
        if ($solicitant) {
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $solicitant->name,
                    'title' => __('general.rescheduling_approved'),
                    'description' => 'El estado de la actividad PIAT ' . $this->activity->name . ' ha cambiado a No Terminado. ',
                    'url' => route('piat.piat_rescheduling', $this->activity->id),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => trans('general.rescheduling_approved'),
                    'greeting' => __('general.dear_user'),
                    'line' => 'El estado de la actividad PIAT' . $this->activity->name . ' ha cambiado a No Terminado. ',
                    'salutation' => trans('general.salutation'),
                    'url' => route('piat.piat_rescheduling', $this->activity->id),
                ]
            ];
            foreach ($notificationArray as $notification) {
                $notificationData = [
                    'user' => $solicitant,
                    'notificationArray' => $notification,
                ];
                $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
            }
        }
        return redirect()->route('piat.piat_rescheduling', $this->activity->id);
    }

    public function resetForm()
    {
        $this->rescheduling->approved_id = null;
    }
}
