<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Company;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Livewire\Component;

class UserAssignCompanies extends Component
{
    public $companies = [];
    public $user;
    public $existingCompanies = [];

    protected $listeners = [
        'openUserAssignCompanies',
    ];

    public function mount()
    {
        $this->companies = Company::get()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.user-assign-companies');
    }

    public function openUserAssignCompanies($idUser = null)
    {
        if ($idUser) {
            $this->user = User::find($idUser);
            $this->existingCompanies = $this->user->companies->pluck('id')->toArray();
        }
    }

    public function update()
    {
        try {
            \DB::beginTransaction();
            $this->user->companies()->sync( $this->existingCompanies );
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
        $this->reset(['existingCompanies', 'user']);
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
