<?php

namespace App\Http\Livewire\Poa\ChangeControl;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use function view;

class PoaChangeControlDetail extends Component
{

    public Activity $activity;

    protected $listeners = ['open' => 'mount'];

    public function mount($id = null)
    {
        if ($id) {
            $this->activity = Activity::find($id);
            $this->emit('toggleModalPoaChangeControlDetail');
        }
    }

    public function render()
    {
        return view('livewire.poa.change-control.poa-change-control-detail');
    }
}
