<?php

namespace App\Http\Livewire\Projects\Profile\ChangeControl;

use App\Models\Auth\User;
use App\Models\Projects\Project;
use App\Models\Vendor\Spatie\Activity;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProjectChangeControl extends Component
{
    public ?int $projectId = null;

    public Project $project;

    public ?int $selectedUser = null;

    public ?Collection $projectActivities = null, $users = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public array $filtersSelected = [];

    public bool $isFiltering = false;

    public bool $dates = false;

    public $search = '';

    public function cleanAllFilters()
    {
        $this->selectedUser = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->mount();
    }

    public function filter()
    {
        $this->filtersSelected = [];
        if ($this->startDate || $this->endDate) {
            $this->dates = true;
            $this->isFiltering = true;
            $this->filtersSelected[] =
                [
                    'name' => 'Fechas',
                    'type' => 'date'
                ];
        }
        if ($this->selectedUser) {
            $this->isFiltering = true;
            $this->filtersSelected[] =
                [
                    'name' => User::where('id', $this->selectedUser)->first()->name,
                    'type' => 'user'
                ];
        }
        $this->emit('toggleDropDownFilter');
    }

    public function cleanFilter($type)
    {
        switch ($type) {
            case 'user':
                $this->selectedUser = null;
                break;
            case 'date':
                $this->startDate = null;
                $this->endDate = null;
                break;
        }
        $this->filter();
    }

    public function mount($projectId = null)
    {
        $this->projectId = $projectId;
        $this->users = User::enabled()->get();
    }

    public function render()
    {
        $search = $this->search;
        $activitiesLog = Activity::with(['causer','subject'])->where('category_type', Project::class)->where('category_id', $this->projectId)
            ->when($this->startDate, function ($q) {
                $q->where('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($q) {
                $q->where('created_at', '<=', $this->endDate);
            })
            ->when($this->selectedUser, function ($q) {
                $q->where('causer_id', $this->selectedUser);
            })
            ->when($search, function ($q, $search) {
                $q->where('description', 'iLIKE', '%' . $search . '%');
            })
            ->orderBy('created_at','DESC')
            ->paginate(10);

        $this->isFiltering = false;
        $this->dates = false;
        return view('livewire.projects.profile.change_control.project-change-control', compact('activitiesLog'));
    }
}
