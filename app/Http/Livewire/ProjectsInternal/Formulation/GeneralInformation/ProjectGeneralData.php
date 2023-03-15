<?php

namespace App\Http\Livewire\ProjectsInternal\Formulation\GeneralInformation;

use App\Models\Admin\Department;
use App\Models\Common\Catalog;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectFunder;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMemberArea;
use App\Models\Projects\ProjectReferentialBudget;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ProjectGeneralData extends Component
{

    public $project;

    public $projectLocationId;
    public $projectLocationDescription;
    public $projectLocation = null;

    public $years = 0;
    public $months = 0;
    public $weeks = 0;
    public $resultTimeEstimated = 0;

    public $foundersSelect = [];
    public $existing_founders = [];
    public array $auxFounders;

    public $cooperatorsSelect = [];
    public $existing_cooperators = [];
    public array $auxCooperators;

    public $locationsSelect = [];
    public $existing_locations = [];
    public array $auxLocations = [];

    public $executorAreas = [];
    public $executorAreasAux = [];
    public $executorAreasSelect = [];

    public $area;
    public $areas = [];


    public $founders;
    public $cooperators;
    public $location = [];
    public $selectLocation;
    public $oldSelectLocation;
    public $messagesList;


    public function mount(Project $project, $messagesList=null)
    {
        $this->project = $project;
        $this->project = $project;
        $this->projectLocationId = $this->project->location_id;
        $this->projectLocationDescription = $this->project->location ? $this->project->location->getPath() : '';
        $time = explode(",", $this->project->estimated_time);
        $this->years = $time[0] ?? 0;
        $this->months = $time[1] ?? 0;
        $this->weeks = $time[2] ?? 0;
        $this->resultTimeEstimated = $time[3] ?? 0;

        if (isset($this->project->funders)) {
            $this->existing_founders = $this->project->funders->pluck('id');
            $this->auxFounders = array();
            foreach ($this->existing_founders as $index => $ind) {
                $this->auxFounders[$index] = $ind;
            }
        }

        if (isset($this->project->cooperators)) {
            $this->existing_cooperators = $this->project->cooperators->pluck('id');
            $this->auxCooperators = array();
            foreach ($this->existing_cooperators as $index => $ind) {
                $this->auxCooperators[$index] = $ind;
            }
        }

        if ($this->project->locations->count() > 0) {
            $this->existing_locations = $this->project->locations->pluck('id');
            $this->selectLocation = $this->project->locations->first()->type;
            $this->oldSelectLocation = $this->selectLocation;
            $type = $this->selectLocation;
            $this->location = CatalogGeographicClassifier::when($this->selectLocation, function ($q) use ($type) {
                $q->where('type', $type);
            })->get();
            $this->auxLocations = array();
            foreach ($this->existing_locations as $index => $ind) {
                $this->auxLocations[$index] = $ind;
            }
        }

        $this->areas = Department::with(['parent'])->enabled()->get();
        $this->executorAreas = $this->areas;
        foreach ($this->project->areas as $item) {
            array_push($this->executorAreasAux, $item->department_id);
        }
        $this->founders = ProjectFunder::get();
        $this->cooperators = ProjectAssistant::get();
        $this->messagesList=$messagesList;

    }


    public function render()
    {
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);

        return view('livewire.projectsInternal.formulation.general_information.project-general-data');
    }

    public function updatedSelectLocation()
    {
        if ($this->selectLocation != $this->oldSelectLocation) {
            $this->reset(['locationsSelect']);
            $this->project->locations()->sync($this->locationsSelect);
            $this->project->refresh();
        }
        $type = $this->selectLocation;
        $this->location = CatalogGeographicClassifier::when($type, function ($q) use ($type) {
            $q->where('type', $type);
        })->get();
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);

    }

    public function updatedYears()
    {
        $this->calcMonths();

    }

    public function updatedMonths()
    {
        $this->calcMonths();
    }

    public function updatedWeeks()
    {
        $this->calcMonths();
    }


    public function calcMonths()
    {
        $this->resultTimeEstimated = 0;
        $this->resultTimeEstimated += $this->weeks * 0.229984378073;
        if ($this->years) {
            $this->resultTimeEstimated += ($this->years * 12) + ($this->months);
        } else {
            $this->resultTimeEstimated += ($this->months);
            $this->years = 0;
        }
        $this->resultTimeEstimated = round($this->resultTimeEstimated, 0);
        $this->resultTimeEstimated = intval($this->resultTimeEstimated);
        $this->project->estimated_time = $this->years . "," . $this->months . "," . $this->weeks . "," . $this->resultTimeEstimated;
        $this->project->save();
        $this->emit('timeUpdated', $this->project, $this->messagesList);
        foreach ($this->project->objectives as $objective) {
            foreach ($objective->results as $result) {
                $result->planning = null;
                $result->save();
            }
        }
    }

    public function updatedFoundersSelect()
    {
        $this->project->funders()->sync($this->foundersSelect);

        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);
    }

    public function updatedCooperatorsSelect()
    {
        $this->project->cooperators()->sync($this->cooperatorsSelect);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);
    }

    public function updatedLocationsSelect()
    {

        $this->project->locations()->sync($this->locationsSelect);
        $this->project->refresh();
        $this->existing_locations = $this->project->locations->pluck('id');
        $this->selectLocation = $this->project->locations->first()->type;
        $type = $this->selectLocation;
        $this->location = CatalogGeographicClassifier::when($this->selectLocation, function ($q) use ($type) {
            $q->where('type', $type);
        })->get();
        $this->auxLocations = array();
        foreach ($this->existing_locations as $index => $ind) {
            $this->auxLocations[$index] = $ind;
        }
        $this->project->location_id = $this->locationsSelect;
        $this->project->save();
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);

    }
}
