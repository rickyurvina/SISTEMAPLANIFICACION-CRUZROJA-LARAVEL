<?php

namespace App\Http\Livewire\User;

use App\Models\Auth\Role;
use App\Models\Auth\User;

use App\Models\Poa\PoaActivity;
use Illuminate\Support\Collection;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;
    protected $user_id = null;
    public $poaActivities;

    public ?Collection $companies = null, $userRolesIds = null, $roles = null, $comments = null;

    public function mount($id = null)
    {
        if ($id) {
            $this->user = User::where('id',$id)->with(['roles','companies',
                'companies','comments','projects.members','indicators','poas','activityLog','measures'])->first();
            $this->poaActivities=PoaActivity::with(['program.poa'])->where('user_id_in_charge',$this->user->id)->get();
        }
    }

    public function render()
    {
        return view('livewire.user.user-profile');
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
