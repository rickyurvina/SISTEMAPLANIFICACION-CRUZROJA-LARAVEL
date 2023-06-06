<?php

namespace App\Http\Livewire\Projects\Formulation\GeneralInformation;

use App\Models\Admin\Department;
use App\Models\Common\Catalog;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectFunder;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectMemberArea;
use App\Models\Projects\ProjectReferentialBudget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
    public $selectLocation = 'PROVINCE';
    public $oldSelectLocation = '';
    public $messagesList;


    public function mount(Project $project, $messagesList = null)
    {
        $this->project = $project;
        $this->projectLocationId = $this->project->location_id;
        $this->projectLocationDescription = $this->project->location ? $this->project->location->getPath() : '';
        $this->months = $this->project->estimated_time ?? 0;
        $this->resultTimeEstimated = $this->project->estimated_time ?? 0;
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

        $this->existing_locations = $this->project->locations->pluck('id');
        $type = $this->selectLocation;
        $this->location = CatalogGeographicClassifier::when($this->selectLocation, function ($q) use ($type) {
            $q->where('type', $type);
        })->get();
        $this->auxLocations = array();
        foreach ($this->existing_locations as $index => $ind) {
            $this->auxLocations[$index] = $ind;
        }

        $this->areas = Department::with(['parent'])->enabled()->get();
        $this->executorAreas = $this->areas;
        foreach ($this->project->areas as $item) {
            array_push($this->executorAreasAux, $item->department_id);
        }
        $this->founders = ProjectFunder::get();
        $this->cooperators = ProjectAssistant::get();
        $this->messagesList = $messagesList;
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);
    }


    public function render()
    {
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);
        return view('livewire.projects.formulation.general_information.project-general-data');
    }

    public function updatedMonths()
    {
        try {
            DB::beginTransaction();
            $this->project->estimated_time = $this->months;
            $this->project->save();
            $this->emit('timeUpdated', $this->project, $this->messagesList);
            foreach ($this->project->objectives as $objective) {
                foreach ($objective->results as $result) {
                    $result->planning = null;
                    $result->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage())->error()->livewire($this);
        }
    }

    public function updatedFoundersSelect()
    {
        try {
            DB::beginTransaction();
            $this->project->funders()->sync($this->foundersSelect);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            flash(trans_choice('messages.error.updated', 0, ['type' => trans_choice('general.project', 1)]))->error()->livewire($this);
        }
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);
    }

    public function updatedCooperatorsSelect()
    {
        $this->project->cooperators()->sync($this->cooperatorsSelect);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);
    }

    public function updatedLocationsSelect()
    {
        try {
            DB::beginTransaction();
            $this->project->locations()->sync($this->locationsSelect);
            $this->project->refresh();
            DB::commit();
            if ($this->project->locations()->count() >= 1) {
                $this->project->location_id = $this->project->locations->first()->id;
            } else {
                $this->project->location_id = null;
            }
            $this->project->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            flash(trans_choice('messages.error.updated', 0, ['type' => trans_choice('general.project', 1)]))->error()->livewire($this);
        }
        $this->existing_locations = $this->project->locations->pluck('id');
        $type = $this->selectLocation;
        $this->location = CatalogGeographicClassifier::when($this->selectLocation, function ($q) use ($type) {
            $q->where('type', $type);
        })->get();
        $this->auxLocations = array();
        foreach ($this->existing_locations as $index => $ind) {
            $this->auxLocations[$index] = $ind;
        }
        $this->dispatchBrowserEvent('showLocations', ['data' => $this->location]);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 1)]))->success()->livewire($this);

    }
}
