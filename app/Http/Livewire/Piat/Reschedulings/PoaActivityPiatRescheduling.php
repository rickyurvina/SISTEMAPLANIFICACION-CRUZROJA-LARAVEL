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

class PoaActivityPiatRescheduling extends Component
{
    use Jobs;

    public $activity;
    public $description;

    public function mount(int $piatId)
    {
        $this->activity = PoaActivityPiat::find($piatId);
    }

    public function render()
    {
        return view('livewire.piat.reschedulings.poa-activity-piat-rescheduling');
    }

    public function create()
    {
        $data = $this->validate([
            'description' => 'required',
        ]);
        $data += [
            'description' => $this->description,
            'status' => \App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUS_OPENED,
            'poa_activity_piat_id' => $this->activity->id,
            'user_id' => user()->id,
        ];
        $response = $this->ajaxDispatch(new \App\Jobs\Poa\PoaPiatActivityCreateRescheduling($data));
        $user = User::find($this->activity->created_by);

        if ($this->activity->created_by && $response['success'] && $user) {
            $notificationArray = [];
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => trans('general.generated_rescheduling'),
                    'description' => 'Se ha generado una solicitud de reprogramación en la actividad PIAT ' . $this->activity->name,
                    'url' => route('piat.piat_rescheduling', $this->activity->id),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => trans('general.generated_rescheduling'),
                    'greeting' => __('general.dear_user'),
                    'line' => 'Se ha generado una solicitud de reprogramación en la actividad PIAT ' . $this->activity->name,
                    'salutation' => trans('general.salutation'),
                    'url' => route('piat.piat_rescheduling', $this->activity->id),
                ]
            ];
            foreach ($notificationArray as $notification) {
                $notificationData = [
                    'user' => $user,
                    'notificationArray' => $notification,
                ];
                $notificationResponse = $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
            }
            flash(trans_choice('messages.success.added', 1, ['type' => trans('general.rescheduling')]))->success();
            return redirect()->route('piat.piat_rescheduling', $this->activity->id);
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error()->livewire($this);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'description',
        ]);
    }
}
