<?php

namespace App\Http\Livewire\Process\NonConformities;

use App\Abstracts\TableComponent;
use App\Models\Process\NonConformities;
use App\Models\Process\Process;
use App\Traits\Jobs;

class NonConformitiesIndex extends TableComponent
{
    use  Jobs;

    public $process;
    public $subMenu;
    public $pageIndex;
    public string $search = '';

    protected $listeners = ['nonConformityCreated' => 'render'];

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
        $nonConformities = NonConformities::with(['actions'])->where('process_id', $this->process->id)
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($search, function ($q) {
                $q->where(function ($query) {
                    $query->where('number', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('code', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('description', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('type', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('evidence', 'iLIKE', '%' . $this->search . '%');
                });
            })->paginate(setting('default.list_limit', '25'));
        return view('livewire.process.non-conformities.non-conformities-index',compact('nonConformities'));
    }

    public function delete($id)
    {
        $nonConformity = NonConformities::find($id);
        $response = $this->ajaxDispatch(new \App\Jobs\Process\DeleteNonConformity($nonConformity));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans('general.nonconformity')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
