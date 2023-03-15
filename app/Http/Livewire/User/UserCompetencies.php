<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class UserCompetencies extends Component
{
    public User $user;
    public ?Collection $comments = null;

    protected $listeners = ['showCompetencies' => 'render'];

    public function mount($id = null)
    {
        if ($id) {
            $this->user = $id;
        }
    }

    public function render()
    {
        return view('livewire.user.user-competencies');
    }
}
