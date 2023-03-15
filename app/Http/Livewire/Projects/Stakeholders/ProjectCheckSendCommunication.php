<?php

namespace App\Http\Livewire\Projects\Stakeholders;

use App\Models\Projects\Project;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;


class ProjectCheckSendCommunication extends Component
{
    use WithFileUploads, Uploads, Jobs;

    public $communication;
    public array $reports;
    public $reportSelected;
    public $viewUploadFile = false;
    public $file = null;
    public $files = [];
    public $observation = null;
    public $fileEdit;
    public $filesEdit = [];
    public $project;
    public $identifier;
    public $mediaId;

    protected $listeners = ['openSend'];

    protected $rules = [
        'observation' => 'required',
        'file' => 'required|file'
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.stakeholders.project-check-send-communication');
    }

    public function resetForm()
    {

        $this->reset(
            [
                'files',
                'file',
                'observation',
                'fileEdit',
                'filesEdit',
            ]
        );
    }


    public function openSend($id)
    {
        $this->communication = ProjectCommunicationMatrix::with(['stakeholder.interested'])->find($id);
        $this->reports = ProjectCommunicationMatrix::REPORTS;
    }

    public function save()
    {
        $this->validate();
        $this->files = [];
        $fileElement = [];
        $fileElement['name'] = substr($this->file, 5);
        $fileElement['file'] = $this->file;
        $fileElement['observation'] = $this->observation;
        $fileElement['user_id'] = Auth::id();
        $fileElement['identifier'] = $this->identifier;
        array_push($this->files, $fileElement);
        $this->observation = '';
        try{
            foreach ($this->files as $item) {
                $this->mediaId = $this->getMedia($item['file'], 'communications', null, $item['observation'], $item['user_id'], null, $item['identifier'])->id;
                $this->communication->attachMedia($this->mediaId, 'file');
                $this->communication->state = ProjectCommunicationMatrix::DELIVERED;
                $this->communication->save();
            }
            $media = Media::find($this->mediaId);
            flash(trans_choice('messages.success.sent', 0, ['type' => trans_choice('general.file_', 0)]))->success()->livewire($this);
            $user = ProjectStakeholder::find($this->communication->prj_project_stakeholder_id)->interested;
            if ($user) {
                $notificationArray = [];
                $notificationArray[0] = [
                    'via' => ['database'],
                    'database' => [
                        'username' => $user->name,
                        'title' => 'Documento recibido',
                        'description' => user()->name . ' ' . user()->surname . ' envió un documento en comunicación en el proyecto ' . $this->project->name . '.',
                        'salutation' => trans('general.salutation'),
                        'url' => route('projects.communication', $this->project->id),
                    ],
                ];
                $notificationArray[1] = [
                    'via' => ['mail'],
                    'mail' => [
                        'subject' => ('Documento recibido'),
                        'greeting' => __('general.dear_user'),
                        'line' => __(user()->name . ' ' . user()->surname . ' envió un documento en comunicación en el proyecto: ' . $this->project->name . '.'),
                        'salutation' => trans('general.salutation'),
                        'url' => route('projects.communication', $this->project->id),
                        'attach' => $this->file,
                        'as' => $media->filename . '.' . $media->extension,
                        'mime' => $media->mime_type,
                    ]
                ];
                foreach ($notificationArray as $notification) {
                    $data = [
                        'user' => $user,
                        'notificationArray' => $notification,
                    ];
                    $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($data));
                }

            }
            $message = trans_choice('messages.success.imported', 0, ['type' => trans('general.prj_files')]);
            flash($message)->success();
            $this->dispatchBrowserEvent('fileReset');
        }catch (\Exception $e){
            flash($e)->error();
        }
        return redirect()->route('projects.communication', $this->communication->stakeholder->project);
    }
}
