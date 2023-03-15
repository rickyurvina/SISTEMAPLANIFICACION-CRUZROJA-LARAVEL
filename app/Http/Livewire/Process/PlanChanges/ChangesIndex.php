<?php

namespace App\Http\Livewire\Process\PlanChanges;

use App\Abstracts\TableComponent;
use App\Models\Process\Process;
use App\Models\Process\ProcessPlanChanges;

class ChangesIndex extends TableComponent
{
    public $process;
    public $subMenu;
    public $pageIndex;
    public string $search = '';

    protected $listeners = ['planChangeCreated' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function mount(int $processId, string $subMenu, string $page)
    {
        $this->process = Process::find($processId);
        $this->pageIndex = $page;
        $this->subMenu = $subMenu;
    }

    public function render()
    {
        $search = $this->search;
        $planChanges = ProcessPlanChanges::where('process_id', $this->process->id)
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($search, function ($q) {
                $q->where(function ($query){
                    $query->where('description', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('date', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('objective', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('objective', 'iLIKE', '%' . $this->search . '%');
                });
            })->collect();
        return view('livewire.process.planChanges.changes-index',compact('planChanges'));
    }
}
