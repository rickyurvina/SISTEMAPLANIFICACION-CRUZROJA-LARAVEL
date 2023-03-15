<?php

namespace App\Http\Livewire\Process\Activities;

use App\Abstracts\TableComponent;
use App\Models\Process\Activity;
use App\Models\Process\Process;
use Livewire\Component;

class ActivitiesIndex extends TableComponent
{
    public $process;
    public $subMenu;
    public $pageIndex;
    public string $search = '';

    protected $listeners = ['activityCreated' => 'render'];

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
        $activities = Activity::with(['risks'])->where('process_id', $this->process->id)
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($search, function ($q) {
                $q->where(function ($query) {
                    $query->where('code', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('name', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('expected_result', 'iLIKE', '%' . $this->search . '%');
                });
            })->collect();
        return view('livewire.process.activities.activities-index', compact('activities'));
    }
}
