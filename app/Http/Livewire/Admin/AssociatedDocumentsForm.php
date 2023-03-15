<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\InstitutionType;
use App\Traits\Uploads;
use App\Traits\Jobs;
use Livewire\Component;
use Livewire\WithFileUploads;

class AssociatedDocumentsForm extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $file=null;
    public $files = [];
    public $project;

    public function render()
    {
        return view('livewire.admin.associated-documents-form');
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'file' => 'required',
        ]);
  
        $validatedData['file'] = $this->file->store('files', 'public');
  
        File::create($validatedData);
  
        session()->flash('message', 'File successfully Uploaded.');
    }
}
