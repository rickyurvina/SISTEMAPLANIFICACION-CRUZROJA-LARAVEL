<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Permission extends Component
{

    public $role;

    public $permissions;

    public $actions;

    public $selectedPermissions = [];

    public function mount($permissions, $actions, $role = null)
    {
        $this->permissions = $permissions;
        $this->actions = $actions;
        $this->role = $role;

        if ($this->role) {
            $this->selectedPermissions = array_map('strval', $this->role->getAllPermissions()->pluck('id')->toArray());
        }
    }

    public function selectAll()
    {
        $this->selectedPermissions = [];
        foreach ($this->permissions as $key => $permissions) {
            foreach ($permissions as $permission) {
                $this->selectedPermissions[] = strval($permission['id']);
            }
        }
    }

    public function unSelectAll()
    {
        $this->selectedPermissions = [];
    }

    public function select($action)
    {
        foreach ($this->permissions[$action] as $permission) {
            if(!in_array($permission['id'], $this->selectedPermissions)){
                $this->selectedPermissions[] = strval($permission['id']);
            }
        }
    }

    public function unSelect($action)
    {
        foreach ($this->permissions[$action] as $permission) {
            $key = array_search($permission['id'], $this->selectedPermissions);
            if($key !== false){
                unset($this->selectedPermissions[$key]);
            }
        }

        $this->selectedPermissions = array_values($this->selectedPermissions);
    }

    public function render()
    {
        return view('livewire.auth.permission');
    }
}
