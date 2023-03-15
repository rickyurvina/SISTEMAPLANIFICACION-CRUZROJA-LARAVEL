<?php

namespace App\Http\Livewire\Poa\Activity;

use App\Abstracts\TableComponent;
use App\Models\Poa\PoaActivity as ActivityModel;
use App\Models\Poa\PoaProgram;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class PoaShowActivity extends TableComponent
{
    use WithPagination;

    public int $idPoa;

    public $search = '';

    public $programs;

    public array $selectedPrograms = [];

    protected $queryString = [
        'search' => ['except' => ''],

    ];

    public function mount(int $idPoa)
    {
        $this->idPoa = $idPoa;
        $this->loadPrograms();
    }

    public function render()
    {
        $activities = ActivityModel::with(
            [
                'poaActivityIndicator',
                'responsible',
                'planDetail',
                'measure',
                'measureAdvances',
                'program',
            ])
            ->whereHas('program', function (Builder $query) {
                $query->where('poa_id', $this->idPoa);
            })
            ->when(!empty($this->search), function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('code', 'iLike', '%' . $this->search . '%')
                        ->orWhere('name', 'iLike', '%' . $this->search . '%');
                });
            })
            ->when(count($this->selectedPrograms) > 0, function (Builder $query) {
                $query->whereIn('poa_program_id', $this->selectedPrograms);
            })
            ->orderBy('plan_detail_id', 'asc')
            ->orderBy('measure_id', 'asc')
            ->with(['responsible', 'measure', 'planDetail', 'program'])
            ->withCount('comments')
            ->paginate(setting('default.list_limit', '25'));

        return view('livewire.poa.activity.poa-show-activities', compact('activities'));
    }

    public function loadPrograms()
    {
        $this->programs = PoaProgram::with(['planDetail'])->where('poa_id', $this->idPoa)->get();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedPrograms = [];
    }
}
