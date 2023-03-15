<?php

namespace App\Http\Livewire\Process\NonConformities\Actions;

use App\Models\Auth\User;
use App\Models\Process\NonConformities;
use App\Models\Process\NonConformitiesActions;
use App\Models\Process\Process;
use App\Notifications\OverDueActivityNotification;
use App\Traits\Jobs;
use Carbon\Carbon;
use Livewire\Component;
use function view;

class CreateNonConformityActions extends Component
{

    use Jobs;

    public $nonConformityId;
    public $name;
    public $user_id;
    public $implantation_date;
    public $processId;
    public $start_date;
    public $end_date;
    public $status = NonConformitiesActions::STATUS_OPEN;
    public $users;

    public function rules()
    {
        return [
            'name' => 'required|max:200',
            'implantation_date' => 'required|date',
            'status' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'required',
            'nonConformityId' => 'required'
        ];
    }

    public function mount($nonConformityId)
    {
        $this->nonConformityId = $nonConformityId;
        $this->processId = NonConformities::find($this->nonConformityId)->process_id;
        $this->users = User::get();
    }

    public function render()
    {
        return view('livewire.process.non-conformities.actions.create-non-conformity-actions');
    }

    public function save()
    {
        $data = $this->validate();
        $data += [
            'processes_non_conformities_id' => $this->nonConformityId,
        ];
        $user = User::find($data['user_id']);
        $processOwner = Process::find($this->processId)->owner;
        $page = Process::PHASE_ACT;
        $response = $this->ajaxDispatch(new \App\Jobs\Process\CreateNonConformityAction($data));
        if ($user && $processOwner) {
            $notificationArray = [];
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.responsible') . ' ' . __('general.of') . ' ' . __('general.nonconformity'),
                    'description' => __($user->name . ' ha sido asignado como responsable en la acción ' . $data['name'] . '.'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.responsible') . ' ' . __('general.of') . ' ' . __('general.nonconformity'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($user->name . ' ha sido asignado como responsable en la acción ' . $data['name'] . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                ]];
            $notificationArray[2] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.created'),
                    'description' => __($processOwner->name . ' se ha creado la acción ' . $data['name'] . '.'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[3] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.created'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($processOwner->name . ' se ha creado la acción ' . $data['name'] . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                ]];
            foreach ($notificationArray as $index => $notification) {
                if ($index <= 1)
                    $notificationData = [
                        'user' => $user,
                        'notificationArray' => $notification,
                    ];
                else
                    $notificationData = [
                        'user' => $processOwner,
                        'notificationArray' => $notification,
                    ];
                $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
            }
        }
        //notification for activity started
        if($this->start_date)
        {
            $start_date= new Carbon($this->start_date);
            $notification=[];
            $notification[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity_action_started'),
                    'description' => __($user->name . ' la acción ' . $data['name'] . ' ha iniciado.'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notification[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity_action_started'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($user->name . ' la acción ' . $data['name'] . ' ha iniciado.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                ]];
            foreach ($notification as $notificationD) {
                    $notificationData1 = [
                        'user' => $user,
                        'notificationArray' => $notificationD,
                    ];
                $this->ajaxDispatch(new \App\Jobs\Notifications\ActivityStarted($notificationData1,$start_date));
            }
        }
        if($this->end_date)
        {
            $end_date= new Carbon($this->end_date);
            if ($end_date->diffInDays(now()) >= 2) {
                $notification=[];
                $notification[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('general.nonconformity_action_due'),
                        'description' => __($user->name . ' la acción ' . $data['name'] . ' está por vencerse.'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                        'salutation' => trans('general.salutation'),
                    ]];
                $notification[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => __('general.nonconformity_action_due'),
                        'greeting' => __('general.dear_user'),
                        'line' =>  __($user->name . ' la acción ' . $data['name'] . ' está por vencerse.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    ]];
                foreach ($notification as $notificationD) {
                    $notificationData2 = [
                        'user' => $user,
                        'notificationArray' => $notificationD,
                    ];
                    $user->notifyAt(new \App\Notifications\ActivityDueNotification($notificationData2), $end_date->subDays(2));
                }
            } else {
                $notification=[];
                $notification[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('general.nonconformity_action_due'),
                        'description' => __($user->name . ' la acción ' . $data['name'] . ' está por vencerse.'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                        'salutation' => trans('general.salutation'),
                    ]];
                $notification[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => __('general.nonconformity_action_due'),
                        'greeting' => __('general.dear_user'),
                        'line' =>  __($user->name . ' la acción ' . $data['name'] . ' está por vencerse.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    ]];
                foreach ($notification as $notificationD) {
                    $notificationData2 = [
                        'user' => $user,
                        'notificationArray' => $notificationD,
                    ];
                    $user->notifyAt(new \App\Notifications\ActivityDueNotification($notificationData2), $end_date->subDays(1));
                }
            }
            if ($end_date >= now()) {
                $notification=[];
                $notification[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => __('general.nonconformity_action_dued'),
                        'description' => __($user->name . ' la acción ' . $data['name'] . ' ya venció.'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                        'salutation' => trans('general.salutation'),
                    ]];
                $notification[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => __('general.nonconformity_action_dued'),
                        'greeting' => __('general.dear_user'),
                        'line' =>  __($user->name . ' la acción ' . $data['name'] . ' ya venció.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('process.showConformities', ['process' => $this->processId, 'page' => $page]),
                    ]];
                foreach ($notification as $notificationD) {
                    $notificationData3 = [
                        'user' => $user,
                        'notificationArray' => $notificationD,
                    ];
                    $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData3));
                }
                $user->notifyAt(new OverDueActivityNotification(), now());
            }
        }
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('general.action')]))->success()->livewire($this);
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
            'name',
            'implantation_date',
            'start_date',
            'end_date',
            'user_id',
        ]);
        $this->emit('actionCreated');
        $this->emit('toggleCreateAction');
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset([
            'name',
            'implantation_date',
            'start_date',
            'end_date',
            'user_id',
        ]);
    }
}
