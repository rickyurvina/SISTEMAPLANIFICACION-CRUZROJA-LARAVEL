<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\User;

use Illuminate\Support\Collection;
use Livewire\Component;

class UserShowConnections extends Component
{
    public User $user;
    public ?Collection $connections = null;

    protected $listeners = ['showConnections' => 'render'];

    public function mount($id = null)
    {
        if ($id) {
            $this->user = $id;
            $this->connections = $this->user->activityLog;
        }
    }

    public function render()
    {
        return view('livewire.user.user-show-connections');
    }
}
