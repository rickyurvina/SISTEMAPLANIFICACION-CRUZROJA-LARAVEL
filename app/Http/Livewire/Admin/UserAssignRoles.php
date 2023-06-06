<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Auth\UpdateUser;
use App\Models\Admin\Company;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Livewire\Component;

class UserAssignRoles extends Component
{
    public $roles = [];
    public $user;
    public array $userRolesIds = [];

    protected $listeners = [
        'openUserAssignRoles',
    ];

    public function mount()
    {
        $this->roles = Role::notSuperAdmin()->get()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.user-assign-roles');
    }

    public function openUserAssignRoles($idUser = null)
    {
        if ($idUser) {
            $this->user = User::find($idUser);
            $this->userRolesIds = $this->user->roles->pluck('id')->toArray();
        }
    }

    public function update()
    {
        try {
            \DB::beginTransaction();
            $this->user->roles()->sync($this->userRolesIds);
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.users', 1)]))->success();
            \DB::commit();
            return redirect(route('users.index'));
        }catch (\Exception $exception){
            \DB::rollBack();
            flash($exception->getMessage())->error()->livewire($this);
        }

    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->reset(['userRolesIds', 'user']);
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
