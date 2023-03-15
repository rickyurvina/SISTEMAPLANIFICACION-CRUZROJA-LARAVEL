<?php

namespace App\Http\Livewire\Projects\Governance;

use App\Events\Projects\ProjectSubsidiaryUpdated;
use App\Jobs\Projects\ProjectCreateSubsidiary;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMemberArea;
use App\Models\Projects\ProjectMemberSubsidiary;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectMembersGovernance extends Component
{
    use Jobs;

    public $project;

    public string $subsidiary;

    public $subsidiaries = [];
    public $subsidiariesAux = [];
    public $subsidiariesSelect = [];

    public $area;
    public $areas = [];

    public $executorAreas = [];
    public $executorAreasAux = [];
    public $executorAreasSelect = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->subsidiary = $this->project->company->name;
        $this->subsidiaries = Company::with(['parent'])->where('level', '>=', '2')->get();
        foreach ($this->project->subsidiaries as $item) {
            array_push($this->subsidiariesAux, $item->company_id);
        }
        $this->areas = Department::with(['parent'])->withoutGlobalScope(\App\Scopes\Company::class)->whereIn('company_id', $project->subsidiaries->pluck('company_id'))->enabled()->get();
        $this->executorAreas = $this->areas;
        foreach (ProjectMemberArea::where('project_id', $this->project->id)->pluck('department_id') as $item => $index) {
            array_push($this->executorAreasAux, $index);
        }
        $this->area = $this->project->department_id;
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadAreas');
        return view('livewire.projects.governance.project-members-governance');
    }

    /**
     * Update $subsidiariesSelect selected
     *
     */
    public function updatedSubsidiariesSelect()
    {
        $subsidiariesArray = [];
        $subsidiariesDeletes = ProjectMemberSubsidiary::where('project_id', $this->project->id)->where('company_id', '<>', session('company_id'))->whereNotIn('company_id', $this->subsidiariesSelect)->get();
        if ($subsidiariesDeletes->count() > 0) {
            $subsidiariesDeletes->each->delete();
        }
        foreach ($this->subsidiariesSelect as $item) {
            $subFind = ProjectMemberSubsidiary::where('project_id', $this->project->id)->where('company_id', $item);
            if ($subFind->count() == 0) {
                $memberSubsidiary = new ProjectMemberSubsidiary();
                $memberSubsidiary->project_id = $this->project->id;
                $memberSubsidiary->company_id = $item;
                array_push($subsidiariesArray, $memberSubsidiary);
            }
        }
        if (isset($memberSubsidiary)) {
            $company = Company::find($memberSubsidiary->company_id);
            foreach ($this->project->members as $index => $projectMember) {
                $member = User::find($projectMember->user_id);
                if ($member && $company) {
                    $notificationArray = [];
                    $notificationArray[0] = [
                        'via' => ['database'],
                        'database' => [
                            'username' => $member->name,
                            'title' => __('general.subsidiary_assign'),
                            'description' => __('Se ha asignado a ' . $company->name . ' como implementador local del proyecto ' . $this->project->name . '.'),
                            'url' => route('projects.index'),
                            'salutation' => trans('general.salutation'),
                        ]];
                    $notificationArray[1] = [
                        'via' => ['mail'],
                        'mail' => [
                            'subject' => __('general.subsidiary_assign'),
                            'greeting' => __('general.dear_user'),
                            'line' => __('Se ha asignado a ' . $company->name . ' como implementador local del proyecto ' . $this->project->name . '.'),
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
            }
        }
        ProjectMemberArea::where('project_id', $this->project->id)->delete();

        if (count($subsidiariesArray)) {
            $this->ajaxDispatch(new ProjectCreateSubsidiary($subsidiariesArray, $this->project));
            ProjectSubsidiaryUpdated::dispatch($this->project);
        }
        $this->emit('areasUpdated', $this->project);

        $this->mount($this->project);

        flash(__('general.update_success'))->success()->livewire($this);

    }

    /**
     * Update $executorAreasSelect selected
     *
     */
    public function updatedExecutorAreasSelect()
    {
        $this->executorAreasAux = [];
        foreach ($this->executorAreasSelect as $item) {
            array_push($this->executorAreasAux, $item);
        }
        $this->project->areas()->sync($this->executorAreasSelect);
        flash(__('general.update_success'))->success()->livewire($this);

    }

}
