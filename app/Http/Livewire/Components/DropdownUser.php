<?php

namespace App\Http\Livewire\Components;

use App\Models\Auth\User;
use App\Traits\Jobs;
use Livewire\Component;
use App;

class DropdownUser extends Component
{
    use Jobs;

    public $model;

    public $modelClass;

    public $modelId;

    public $field;

    public $user;

    public $selectedUserId;

    public $newValue;

    public $search;
    public $event;

    public bool $onlyIcon;

    public bool $toLeft;

    public $users = [];

    public function mount(string $modelClass, int $modelId, string $field = 'user_id', $user = null, $usersAdd=null, bool $onlyIcon=false, $event=null,bool $toLeft=false)
    {
        $this->user = $user;
        $this->field = $field;
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->field = $field;
        $this->event=$event;
        $this->onlyIcon=$onlyIcon;
        $this->toLeft=$toLeft;
        if ($usersAdd){
            $this->users=$usersAdd;
        }else{
            $this->users = User::WithMedia()->get();
        }
    }

    public function updatedSelectedUserId()
    {
        if (!$this->model) {
            $this->model = App::make($this->modelClass)::find($this->modelId);
        }

        if (!$this->user || ($this->user->id != $this->selectedUserId)) {
            $this->model->{$this->field} = $this->selectedUserId;
            $this->model->save();
            $this->user = $this->users->firstWhere('id', $this->selectedUserId);
            if ($this->event) {
                $this->emit($this->event,$this->selectedUserId);
            }
        }
    }

    public function updatedSearch()
    {
        $this->users = User::WithMedia()
            ->where('name', 'iLike', '%' . $this->search . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.components.dropdown-user');
    }
}
