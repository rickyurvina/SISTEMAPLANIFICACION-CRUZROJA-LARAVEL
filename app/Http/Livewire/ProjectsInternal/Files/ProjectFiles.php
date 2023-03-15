<?php

namespace App\Http\Livewire\ProjectsInternal\Files;

use App\Models\Projects\Project;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Plank\Mediable\Media;

class ProjectFiles extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $file = null;
    public $files = [];
    public $observation = null;
    public $project = null;

    public $fileEdit;
    public $filesEdit = [];

    public $identifier;

    protected $rules = [
        'observation' => 'required',
        'file' => 'required|file'
    ];

    public function mount(Project $project, $identifier=null)
    {
        $this->identifier=$identifier;
        $this->filesEdit = [];
        $this->project = $project;
        if ($this->project) {
            $this->project->loadMedia(['file']);
            $media=$this->project->media;
            if ($identifier){
                $media=$media->where('identifier', $identifier);
            }
            foreach ($media as $item) {
                $fileElement = [];
                $fileElement['id'] = $item->id;
                $fileElement['name'] = $item->filename;
                $fileElement['file'] = null;
                $fileElement['observation'] = $item->comments;
                $fileElement['user_id'] = Auth::id();
                $fileElement['date'] = $item->created_at;
                $fileElement['identifier'] = $item->identifier;
                $fileElement['delete'] = false;
                array_push($this->filesEdit, $fileElement);
            }
            $this->render();
        }
    }


    public function deleteMedia($id)
    {
        Media::find($id)->delete();
        $this->project->loadMedia(['file']);
        flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.file_', 0)]))->success()->livewire($this);

        $this->mount($this->project);
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

    public function addFile()
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
        foreach ($this->files as $item) {
            $media = $this->getMedia($item['file'], 'projects', null, $item['observation'], $item['user_id'],null, $item['identifier'])->id;
            $this->project->attachMedia($media, 'file');
        }
        flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.file_', 0)]))->success()->livewire($this);

        $this->dispatchBrowserEvent('fileReset');
        $this->mount($this->project);

    }

    public function render()
    {
        $months_list = array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        );
        $filesProject = [
            '01' => [],
            '02' => [],
            '03' => [],
            '04' => [],
            '05' => [],
            '06' => [],
            '07' => [],
            '08' => [],
            '09' => [],
            '10' => [],
            '11' => [],
            '12' => [],
        ];

        foreach ($this->filesEdit as $index => $item_) {
            $month = date('m', strtotime($item_['date']));
            $key = $month;
            if (!array_key_exists($key, $filesProject)) {
                $filesProject[$key][] = $item_;
            } else {
                $filesProject[$key][] = $item_;
            }
        }

        return view('livewire.projectsInternal.files.project-files', compact('filesProject', 'months_list'));
    }
}
