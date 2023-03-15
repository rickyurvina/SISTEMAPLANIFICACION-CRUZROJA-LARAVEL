<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class UserShowWorkExperience extends Component
{
    public User $user;
    public ?Collection $connections = null;

    protected $listeners = ['showWorkExperience' => 'mount'];

    public function mount($id = null)
    {
        if ($id) {
            $this->user = $id;
        }
    }

    public function render()
    {
        return view('livewire.user.user-show-work-experience');
    }
}
