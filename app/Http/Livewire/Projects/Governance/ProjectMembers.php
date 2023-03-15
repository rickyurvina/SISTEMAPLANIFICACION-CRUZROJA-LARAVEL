<?php

namespace App\Http\Livewire\Projects\Governance;

use App\Http\Livewire\Components\Modal;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Common\Catalog;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMember;
use App\Traits\Jobs;

class ProjectMembers extends Modal
{
    use Jobs;

    public $project;

    public ?int $idContact = null;

    public ?\App\Models\Auth\User $selectedContact = null;

    public string $search = '';

    public string $role = '';

    public $roles = [];

    public string $place = '';

    public $places = [];

    public string $responsibilities = '';

    public float $contribution = 0;

    public bool $cardView = true;

    public array $userRolesIds = [];


    protected $rules = [
        'idContact' => 'required',
        'place' => 'required',
        'role' => 'required',
        'responsibilities' => 'required|max:500',
        'contribution' => 'required'
    ];

    protected $listeners = ['areasUpdated' => 'mount'];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->roles = Role::notSuperAdmin()
            ->where('is_project_role', true)
            ->get();
        $this->userRolesIds = [];
        foreach ($this->roles as $rol) {
            $element = [];
            $element['id'] = $rol['id'];
            $element['name'] = $rol['name'];
            $element['selected'] = null;
            array_push($this->userRolesIds, $element);
        }

        $this->places = Catalog::CatalogName('project_member_place')->get();
        $this->role = '';
        $this->place = '';
        $this->cardView = true;
        $this->listView = false;
    }

    public function render()
    {
        if ($this->show === false) {
            $this->idContact = null;
        }
        $this->role = '';
        $this->place = '';

//        $users = User::whereHas('companies', function ($query) {
//            $query->whereIn('id', $this->project->subsidiaries->pluck('company_id'));
//        })->whereHas('departments', function ($q) {
//            $q->when($this->project->areas->pluck('id')->count() > 0, function ($q) {
//                $q->whereIn('id', $this->project->areas->pluck('id'));
//            });
//        })->get();

        $users = User::whereHas('companies', function ($query) {
            $query->whereIn('id', $this->project->subsidiaries->pluck('company_id'));
        })->get();
        return view('livewire.projects.governance.project-members', compact('users'));
    }

    public function delete($id)
    {
        ProjectMember::find($id)->delete();
        flash(trans_choice('messages.success.deleted', 0))->success()->livewire($this);
        $this->show = false;
        $this->reset(['idContact', 'role', 'responsibilities', 'contribution', 'selectedContact', 'search']);
        $this->project->load('members.user');
    }

    public function save()
    {
        $this->validate();

        ProjectMember::create(array_merge([
            'project_id' => $this->project->id,
            'user_id' => $this->idContact,
            'role_id' => $this->role,
            'place_id' => $this->place,
        ], $this->validate()));
        $user = \App\Models\Auth\User::find($this->idContact);
        $rol = Role::find($this->role);
        if (!in_array($this->role, $user->roles->pluck('id')->toArray())) {
            $user->roles()->attach($this->role);
        }
        if ($user && $rol) {
            $notificationArray = [];
            foreach ($this->project->members as $projectMember) {
                $member = User::find($projectMember->user_id);
                if ($member) {
                    $notificationArray[0] = [
                        'via' => ['database'],
                        'database' => [
                            'username' => $member->name,
                            'title' => __('general.add_member_team'),
                            'description' => __($user->name . ' ha sido asignado como ' . $rol->name . ' en el proyecto ' . $this->project->name . '.'),
                            'url' => route('projects.index'),
                            'salutation' => trans('general.salutation'),
                        ]];
                    $notificationArray[1] = [
                        'via' => ['mail'],
                        'mail' => [
                            'subject' => (__('general.add_member_team')),
                            'greeting' => __('general.dear_user'),
                            'line' => __($user->name . ' ha sido asignado como ' . $rol->name . ' en el proyecto ' . $this->project->name . '.'),
                            'salutation' => trans('general.salutation'),
                            'url' => ('projects.index'),
                        ]
                    ];
                    foreach ($notificationArray as $notification) {
                        $notificationData = [
                            'user' => $member,
                            'notificationArray' => $notification,
                        ];
                        $this->ajaxDispatch(new \App\Jobs\Notifications\SendNotification($notificationData));
                    }
                }
                flash(__('general.update_success'))->success()->livewire($this);
            }
        }

        $this->show = false;
        $this->reset(['idContact', 'role', 'responsibilities', 'contribution', 'selectedContact', 'search']);
        $this->project->load('members.user');
    }

    public function updatedIdContact($value)
    {
        if ($value) {
            $this->selectedContact = \App\Models\Auth\User::find($value);
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
