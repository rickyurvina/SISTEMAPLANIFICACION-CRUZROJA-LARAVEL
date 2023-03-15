<?php

namespace App\Http\Livewire\Common;

use App\Models\Auth\User;
use Livewire\Component;

class HeaderNotifications extends Component
{
    public User $user;
    public int $notifications = 0;
    public int $totalNotifications = 0;
    public $unreads = [];
    public $viewAll = 0;

    public function mount($user)
    {
        $this->user = $user;
        $this->unreads = $this->user->unreadNotifications;
        $this->notifications = count($this->unreads);
        $this->totalNotifications = count($this->user->notifications);
    }

    public function render()
    {
        return view('livewire.common.header-notifications');
    }

    public function markRead($id)
    {
        $this->reset([
            'notifications',
            'unreads',
        ]);
        foreach ($this->user->unreadNotifications as $item) {
            if ($item->id == $id) {
                $item->markAsRead();
            }
        }
        $this->user->refresh();
        if ($this->viewAll) {
            $this->unreads = $this->user->notifications;
        } else {
            $this->unreads = $this->user->unreadNotifications;
        }
        $this->notifications = count($this->user->unreadNotifications);
    }

    public function readAll()
    {
        $this->reset([
            'unreads',
        ]);
        if ($this->viewAll) {
            $this->unreads = $this->user->unreadNotifications;
            $this->viewAll = 0;
        } else {
            $this->unreads = $this->user->notifications;
            $this->viewAll = 1;
        }
    }

    public function markAllRead()
    {
        $this->reset([
            'notifications',
            'unreads',
        ]);
        $this->user->unreadNotifications->markAsRead();
        $this->user->refresh();
        if ($this->viewAll) {
            $this->unreads = $this->user->notifications;
        }
    }
}
