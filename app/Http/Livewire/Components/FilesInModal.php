<?php

namespace App\Http\Livewire\Components;

use App;
use Livewire\Component;
use App\Traits\Uploads;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;

class FilesInModal extends Component
{
    use Uploads, WithFileUploads;

    public $model;

    public $files = [];

    public $folder;

    public $identifier;
    public $event;
    public $accept;
    public $limit;


    public function mount(string $model, int $modelId, string $folder, string $identifier = null,$event=null,$accept=null,$limit=null)
    {
        $this->model = App::make($model)::find($modelId);
        $this->model->loadMedia(['file']);
        $this->folder = $folder;
        $this->identifier = $identifier;
        $this->event = $event;
        $this->accept = $accept;
        $this->limit = $limit;
    }

    public function updatedFiles()
    {
        foreach ($this->files as $file) {
            $mediaId = $this->getMedia($file, $this->folder, null, '', user()->id, null, $this->identifier)->id;
            $this->model->attachMedia($mediaId, 'file');
        }
        $this->files = [];
        $this->model->loadMedia(['file']);
        if($this->event){
            $this->emit($this->event);
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

    public function deleteFile($id)
    {
        Media::find($id)->delete();
        $this->model->loadMedia(['file']);
    }


    public function render()
    {
        return view('livewire.components.filesInModal');
    }
}
