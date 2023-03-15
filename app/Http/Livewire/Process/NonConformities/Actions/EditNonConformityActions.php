<?php

namespace App\Http\Livewire\Process\NonConformities\Actions;

use App\Models\Process\NonConformitiesActions;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Livewire\Component;
use function view;

class EditNonConformityActions extends Component
{
    use Jobs;

    public $action;

    protected $listeners = ['openEditAction', 'startDateModified', 'endDateModified', 'statusModified'];


    public function render()
    {
        return view('livewire.process.non-conformities.actions.edit-non-conformity-actions');
    }

    public function openEditAction($id)
    {
        $this->action = NonConformitiesActions::find($id);
    }

    public function statusModified()
    {
        $user = NonConformitiesActions::find($this->action->id)->responsible;
        $page = Process::PHASE_ACT;
        $notificationArray = [];
        $processOwner = Process::find($this->action->nonConformity->process_id)->owner;
        if ($user && $processOwner && $this->action->status == NonConformitiesActions::STATUS_CLOSED) {
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.Done'),
                    'description' => __($user->name . ' se ha cumplido la acción ' . $this->action->name . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.Done'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($user->name . ' se ha cumplido la acción ' . $this->action->name . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                ]];
            $notificationArray[2] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.Done'),
                    'description' => __($processOwner->name . ' se ha cumplido la acción ' . $this->action->name . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[3] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.Done'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($processOwner->name . ' se ha cumplido la acción ' . $this->action->name . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
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
    }

    public function startDateModified()
    {
        $user = NonConformitiesActions::find($this->action->id)->responsible;
        $page = Process::PHASE_ACT;
        $notificationArray = [];
        $processOwner = Process::find($this->action->nonConformity->process_id)->owner;
        if ($user && $processOwner) {
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'description' => __($user->name . ' se ha modificado la fecha de inicio de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($user->name . ' se ha modificado la fecha de inicio de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                ]];
            $notificationArray[2] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'description' => __($processOwner->name . ' se ha modificado la fecha de inicio de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[3] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($processOwner->name . ' se ha modificado la fecha de inicio de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
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
    }

    public function endDateModified()
    {
        $user = NonConformitiesActions::find($this->action->id)->responsible;
        $page = Process::PHASE_ACT;
        $notificationArray = [];
        $processOwner = Process::find($this->action->nonConformity->process_id)->owner;
        if ($user && $processOwner) {
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'description' => __($user->name . ' se ha modificado la fecha fin de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($user->name . ' se ha modificado la fecha fin de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                ]];
            $notificationArray[2] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'description' => __($processOwner->name . ' se ha modificado la fecha fin de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
                    'salutation' => trans('general.salutation'),
                ]];
            $notificationArray[3] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => __('general.nonconformity') . ' ' . __('general.modified'),
                    'greeting' => __('general.dear_user'),
                    'line' => __($processOwner->name . ' se ha modificado la fecha fin de ' . $this->action->name . ' al ' . $this->action->start_date->format('d-m-Y') . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => route('process.showConformities', ['process' => $this->action->nonConformity->process_id, 'page' => $page]),
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
    }

    public function updateIndex()
    {
        $this->emit('updatedAction');
        $this->emit('formClosed');
    }
}
