<?php

namespace App\Http\Livewire\Projects\CRUD;

use App\Abstracts\TableComponent;
use App\Jobs\Projects\DeleteProject;
use App\Models\Projects\Project;
use App\Traits\Jobs;

class Projects extends TableComponent
{
    use Jobs;

    public bool $cardView = true;
    public $search = '';
    public bool $isProjects = false;
    public bool $profiles = false;

    protected $listeners = ['project-created' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $search = $this->search;
        $areProjects = $this->isProjects;
        $areProfiles = $this->profiles;
        if ($areProjects && $areProfiles) {
            $areProjects = false;
            $areProfiles = false;
        }
        $types = [Project::TYPE_MISSIONARY_PROJECT, Project::TYPE_INVESTMENT, Project::TYPE_INTERNAL_DEVELOPMENT, Project::TYPE_EMERGENCY];
        $companyActive = session('company_id');
        $projects = Project::withoutGlobalScope(\App\Scopes\Company::class)->with(['members.user.media', 'responsible', 'location'])
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('phase', 'iLike', '%' . $this->search . '%')
                        ->orWhere('status', 'iLike', '%' . $this->search . '%')
                        ->orWhere('code', 'iLike', '%' . $this->search . '%');
                });
            })->when($areProjects, function ($q, $areProjects) {
                $q->where('project_profile', '!=', $areProjects);
            })->when($areProfiles, function ($q, $areProfiles) {
                $q->where('project_profile', $areProfiles);
            })->paginate(setting('default.list_limit', '25'));

        return view('livewire.projects.crud.projects', [
            'projects' => $projects
        ])->with('types', $types)->with('companyActive', $companyActive);
    }

    public function verifyVisibility()
    {
        $this->cardView = !$this->cardView;
    }

    public function clearFilters()
    {
        $this->reset([
            'isProjects',
            'profiles',
            'search',
        ]);
    }

    public function delete($id)
    {
        $response = $this->ajaxDispatch(new DeleteProject($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
