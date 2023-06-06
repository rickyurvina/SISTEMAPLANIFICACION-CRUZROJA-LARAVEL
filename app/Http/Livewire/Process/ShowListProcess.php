<?php

namespace App\Http\Livewire\Process;

use App\Abstracts\TableComponent;
use App\Jobs\Process\DeleteProcess;
use App\Models\Process\Process;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use function view;

class ShowListProcess extends TableComponent
{
    use  Jobs;

    public $search = '';
    public $departmentId;
    public $typesProcess = [];
    public $selectType = [];

    protected $listeners = ['processCreated' => 'render'];
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function mount(int $departmentId)
    {
        $this->departmentId = $departmentId;
        $this->typesProcess = Process::TYPES;
    }

    public function render()
    {
        $processes = Process::with(['owner', 'indicators', 'department', 'activitiesProcess'])
//            ->where('department_id', $this->departmentId)
//            ->whereHas('department', function ($q) {
//                $q->whereIn('id', \user()->departments->pluck('id'));
//            })
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })->when(count($this->selectType) > 0, function (Builder $query) {
                $query->whereIn('type', $this->selectType);
            })
            ->when($this->search, function ($query) {
                $query->where('code', 'iLIKE', '%' . $this->search . '%')
                    ->orWhere('name', 'iLIKE', '%' . $this->search . '%');
            })
            ->paginate(setting('default.list_limit', '25'));

        return view('livewire.process.show-list-process', compact('processes'));
    }

    public function delete($id)
    {
        $process = Process::find($id);
        $response = $this->ajaxDispatch(new DeleteProcess($process));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.module_process', 1)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'selectType',
                'search',
            ]);
    }
}
