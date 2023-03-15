<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\User;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;

class UserShowFiles extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $file = null;
    public $files = [];
    public $observation = null;
    public $project = null;
    public User $user;
    public ?Collection $connections = null;

    protected $listeners = ['showFiles' => 'render'];

    public function mount($id = null)
    {
        if ($id) {
            $this->user = $id;
        }
    }

    public function deleteMedia($id)
    {
        Media::find($id)->delete();
        $this->user->loadMedia(['file']);
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
        $this->validate([
            'file' => 'required|file',
            'observation' => 'required',
        ]);
        $fileElement = [];
        $fileElement['name'] = substr($this->file, 5);
        $fileElement['file'] = $this->file;
        $fileElement['observation'] = $this->observation;
        $fileElement['user_id'] = Auth::id();
        array_push($this->files, $fileElement);
        $this->observation = '';

        foreach ($this->files as $item) {
            $media = $this->getMedia($item['file'], 'projects', null, $item['observation'],$item['user_id'] )->id;
            $this->user->attachMedia($media, 'file');
        }

        $this->dispatchBrowserEvent('fileReset');
    }

    public function render()
    {
        $medias = $this->user->media()->paginate(5);
        return view('livewire.user.user-show-files', compact('medias'));
    }
}
