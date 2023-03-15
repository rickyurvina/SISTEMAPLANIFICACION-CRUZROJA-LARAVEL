<?php

namespace App\Http\Livewire\Components;

use App\Models\Common\CatalogGeographicClassifier;
use Livewire\Component;
use App;


class Location extends Component
{
    public $model;

    public $modelClass;

    public $modelId;

    public $field;

    public $location;

    public $locations = [];

    public $typeLocation;

    public $selectedLocationId = null;

    public $selectedLocationName = '';

    public $limitLocation = 10;

    public $searchLocation = '';

    public function mount(string $modelClass, int $modelId, string $field = 'location_id', $default = null)
    {
        $this->location = $default;
        $this->field = $field;
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->field = $field;
        if ($this->location) {
            $this->typeLocation = $this->location->type;
            $this->selectedLocationName = $this->location->getPath();
            self::locations();
        }
    }

    public function updatedTypeLocation($value)
    {
        $this->searchLocation = '';
        self::locations();
    }

    public function updatedSearchLocation($value)
    {
        self::locations();
    }

    public function updatedSelectedLocationId($value)
    {
        if (!$this->model) {
            $this->model = App::make($this->modelClass)::find($this->modelId);
        }

        if (!$this->location || ($this->location->id != $this->selectedLocationId)) {
            $this->model->{$this->field} = $this->selectedLocationId;
            $this->model->save();
            $this->location = $this->locations->firstWhere('id', $this->selectedLocationId);
        }

        $this->selectedLocationName = $this->locations->where('id', $value)->first()->getPath();
        $this->searchLocation = '';
        self::locations();
    }

    private function locations()
    {
        $this->locations = CatalogGeographicClassifier::when($this->typeLocation, function ($q) {
            $q->where('type', $this->typeLocation);
        })->when($this->searchLocation != '', function ($q) {
            $q->where(function ($q) {
                $q->where('full_code', 'iLike', '%' . $this->searchLocation . '%')
                    ->orWhere('description', 'iLike', '%' . $this->searchLocation . '%');
            });
        })->limit($this->limitLocation)->get();
    }

    public function render()
    {
        return view('livewire.components.location');
    }
}
