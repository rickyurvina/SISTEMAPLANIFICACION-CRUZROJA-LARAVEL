<?php

namespace App\Http\Livewire\Projects\Formulation\GeneralInformation;

use App\Http\Livewire\Components\Modal;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Common\Catalog;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMember;
use App\Traits\Jobs;


class ProjectMembersFormulation extends Modal
{
    use Jobs;

    public $project;

    public ?int $idContact = null;

    public $selectedContact;

    public string $search = '';

    public string $role = '';

    public $roles = [];

    public string $place = '';

    public $places = [];

    public string $responsibilities = '';

    public float $contribution = 0;

    public array $userRolesIds = [];

    public bool $cardView = true;

    public $messagesList;

    protected $rules = [
        'idContact' => 'required',
        'place' => 'required',
        'role' => 'required',
        'responsibilities' => 'required|max:500',
        'contribution' => 'required'
    ];

    public function mount(Project $project, $messages = null)
    {
        $this->project = $project;
        $this->userRolesIds = [];
        $permission = Permission::IsSuperAdminProject()->first();
        if ($permission) {
            $this->roles = $permission->roles->where('name', '<>', 'admin')
                ->where('name', '<>', 'super-admin');
            foreach ($this->roles as $rol) {
                $element = [];
                $element['id'] = $rol['id'];
                $element['name'] = $rol['name'];
                $element['selected'] = null;
                array_push($this->userRolesIds, $element);
            }
        }
        $this->places = Catalog::CatalogName('project_member_place')->get();
        $this->role = '';
        $this->place = '';
        $this->cardView = true;
        $this->listView = false;
        $this->messagesList = $messages;
    }

    public function render()
    {
        if ($this->show === false) {
            $this->idContact = null;
        }
        if ($this->project->members->count() != 1) {
            $users = User::where('enabled', true)
                ->whereNotIn('id', $this->project->members->pluck('user_id'))
                ->orderBy('surname', 'asc')
                ->search('name', $this->search)
                ->get();
        } else {
            $users = [];
        }
        $this->role = '';
        $this->place = '';

        return view('livewire.projects.formulation.general_information.project-members-formulation', compact('users'));
    }

    public function delete($id)
    {
        ProjectMember::find($id)->delete();
        flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.member', 1)]))->success()->livewire($this);
        $this->show = false;
        $this->reset(['idContact', 'role', 'responsibilities', 'contribution', 'selectedContact', 'search']);
        $this->project->load('members.user');
    }

    public function save()
    {
        $this->validate();
        date_default_timezone_set('America/Guayaquil');
        ProjectMember::create(array_merge([
            'project_id' => $this->project->id,
            'user_id' => $this->idContact,
            'role_id' => $this->role,
            'place_id' => $this->place,
        ], $this->validate()));
        $user = User::find($this->idContact);
        $rol = Role::find($this->role);
        if ($rol->id == 4) {
            $this->project->update(['responsible_id' => $this->idContact]);
        }
        if (!in_array($this->role, $user->roles->pluck('id')->toArray())) {
            $user->roles()->attach($this->role);
        }
        if ($user) {
            $notificationArray = [];
            $notificationArray[0] = [
                'via' => ['database'],
                'database' => [
                    'username' => $user->name,
                    'title' => trans('general.role_assign'),
                    'description' => __('Ha sido asignado como ' . $rol->name . ' en el proyecto ' . $this->project->name),
                    'salutation' => trans('general.salutation'),
                    'url' => route('projects.index'),
                ]];
            $notificationArray[1] = [
                'via' => ['mail'],
                'mail' => [
                    'subject' => (trans('general.role_assign')),
                    'greeting' => trans('general.dear'),
                    'line' => __('Ha sido asignado como ' . $rol->name . ' en el proyecto ' . $this->project->name . '.'),
                    'salutation' => trans('general.salutation'),
                    'url' => ('projects.index'),
                ]
            ];
            foreach ($notificationArray as $notification) {
                $data = [
                    'user' => $user,
                    'notificationArray' => $notification,
                ];
                $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($data));
            }
        }

        flash(__('general.update_success'))->success()->livewire($this);
        $this->show = false;
        $this->reset(['idContact', 'role', 'responsibilities', 'contribution', 'selectedContact', 'search']);

        $this->project->load('members.user');
    }

    public function updatedIdContact($value)
    {
        if ($value) {
            $this->selectedContact = User::find($value);
        } else {
            $this->selectedContact = null;
        }
    }

    public function remove()
    {
        $this->idContact = null;
        $this->selectedContact = null;
        $this->role = '';
        $this->place = '';
    }

    public function verifyVisibility()
    {
        $this->cardView = !$this->cardView;
    }
}
