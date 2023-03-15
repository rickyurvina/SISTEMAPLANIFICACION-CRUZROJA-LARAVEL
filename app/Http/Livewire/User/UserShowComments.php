<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class UserShowComments extends Component
{
    public User $user;
    public ?Collection $comments = null;

    protected $listeners = ['showComments' => 'render'];

    public function mount($id = null)
    {
        if ($id) {
            $this->user = $id;
            $this->comments = $this->user->comments;
        }
    }
    public function render()
    {
        return view('livewire.user.user-show-comments');
    }
}
