<?php

namespace App\Http\Livewire\ProjectsInternal\Profile\ChangeControl;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ProjectChangeControlDetail extends Component
{
    public Activity $activity;

    protected $listeners=['open'=>'mount'];

    public function mount($id=null){
        if ($id){
            $this->activity=Activity::find($id);
            $this->emit('toggleModalProjectChangeControlDetail');
        }
    }

    public function render()
    {
        return view('livewire.projectsInternal.profile.change_control.project-change-control-detail');
    }
}
