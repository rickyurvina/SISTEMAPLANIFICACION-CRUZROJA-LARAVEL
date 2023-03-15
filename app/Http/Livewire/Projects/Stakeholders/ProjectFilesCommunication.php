<?php

namespace App\Http\Livewire\Projects\Stakeholders;

use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;

class ProjectFilesCommunication extends Component
{
    use WithFileUploads, Jobs,Uploads;

    public $communication;
    public $file = null;
    public $files = [];

    protected $listeners = ['openFiles'];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        //$this->communication->media;
        return view('livewire.projects.stakeholders.project-files-communication');
    }

    public function openFiles($id)
    {
        $this->communication=ProjectCommunicationMatrix::find($id);
        if ($this->communication) {
            $this->communication->loadMedia(['file']);
            $media=$this->communication->media;
            foreach ($media as $item) {
                $fileElement = [];
                $fileElement['id'] = $item->id;
                $fileElement['name'] = $item->filename;
                $fileElement['file'] = null;
                $fileElement['observation'] = $item->comments;
                $fileElement['user'] = User::find($item->user_id);
                $fileElement['date'] = $item->created_at;
                $fileElement['delete'] = false;
                array_push($this->files, $fileElement);
            }
            $this->render();
        }
    }
    public function download($id)
    {
        $media = Media::find($id);
        if ($media->fileExists()) {
            return response()->streamDownload(
                function () use ($media) {
                    $stream = $media->stream();
                    while ($bytes = $stream->read(1024)) {
                        echo $bytes;
                    }
                },
                $media->basename,
                [
                    'Content-Type' => $media->mime_type,
                    'Content-Length' => $media->size
                ]
            );
        } else {
            flash(trans('general.file_not_exist'))->error()->livewire($this);
        }
    }

    public function resetModal()
    {
        $this->reset([
            'files',
        ]);
        $this->files=[];
    }
}
