<?php

namespace App\Http\Livewire\Budget\Catalogs;

use App\Abstracts\TableComponent;
use App\Models\Common\CatalogGeographicClassifier;

class GeographicClassifier extends TableComponent
{
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $search = $this->search;
        $geographicClassifier = CatalogGeographicClassifier::when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })->when($search, function ($q) {
            $q->where(function ($query) {
                $query->where('full_code', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('description', 'iLike', '%' . $this->search . '%')
                    ->orWhere('type', 'iLike', '%' . $this->search . '%');
            });
        })->orderBy('id', 'asc')->collect();
        return view('livewire.budget.catalogs.budget-classifier-geographic', compact('geographicClassifier'));
    }
}
