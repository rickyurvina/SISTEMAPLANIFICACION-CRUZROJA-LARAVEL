<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Models\Admin\Company;
use App\Models\Poa\Poa;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class PoaReports extends Component
{
    use WithPagination;

    public $poa;
    public $search = '';
    public $selectYears;
    public $data;
    public $cantons;
    public $selectProvinces;
    public $selectCantons;
    public $actualDay;
    public $provinces;
    public $years = [];

    public function mount()
    {
        $this->cantons = \App\Models\Admin\Company::where('level', 3)->get();
        $this->provinces = \App\Models\Admin\Company::where('level', 2)->get();
        $this->selectYears = now()->year;
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            array_push($this->years, $year);
        }
    }

    public function render()
    {
        $this->load();
        return view('livewire.poa.reports.poa-reports');
    }

    private function load()
    {
        $search = $this->search;
        $this->poa = Poa::withoutGlobalScope(\App\Scopes\Company::class)
            ->with([
                'programs.planDetail',
                'programs.poaActivities' => function ($query) use ($search) {
                    $query->when($search != '', function ($query) use ($search) {
                        $query->where('poa_activities.name', 'iLIKE', '%' . $search . '%');
                    });
                }
            ])
            ->whereHas('programs.poaActivities', function ($query) use ($search) {
                $query->when($search != '', function ($query) use ($search) {
                    $query->where('poa_activities.name', 'iLIKE', '%' . $search . '%');
                });
            })
            ->when($this->selectCantons != null, function ($q) {
                return $q->where('company_id', $this->selectCantons);
            }, function ($q) {
                $q->where('company_id', session('company_id'));
            })
            ->when($this->selectYears != null, function ($q) {
                return $q->where('year', $this->selectYears);
            })->first();
    }

    public function updatedSelectProvinces()
    {
        $this->reset(['selectCantons']);
        $this->cantons = Company::where('level', 3)
            ->when($this->selectProvinces != null, function ($q) {
                return $q->where('parent_id', $this->selectProvinces);
            })->get();
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectYears',
                'selectCantons',
                'selectProvinces',
                'search',
            ]);
    }
}
