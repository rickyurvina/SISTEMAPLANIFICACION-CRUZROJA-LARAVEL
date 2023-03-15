<?php

namespace App\Http\Livewire\Process;

use App\Models\Admin\Department;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class IndexProcess extends Component
{
    public $departmentsFilter;
    public $searchDepartments = '';
    public $selectDepartmentsId = [];
    public $departmentsSelected=[];
    public string $search = '';

    public function mount()
    {
        $this->departmentsFilter = Department::when($this->searchDepartments != '', function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'iLike', '%' . $this->searchDepartments . '%');
            });
        })->get();
    }

    public function render()
    {
        $search = $this->search;
        $departments = Department::with('process.risks', 'process.indicators')
            ->when(count($this->selectDepartmentsId) > 0, function (Builder $query) {
                $query->whereIn('id', $this->selectDepartmentsId);
            })->when($search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('description', 'iLIKE', '%' . $this->search . '%');
                });
            })->paginate(setting('default.list_limit', '25'));
        return view('livewire.process.index-process', compact('departments'));
    }

    public function updatedSearchDepartments($value)
    {
        self::mount();
    }

    public function cleanFilters(){
        $this->reset(
            [
                'selectDepartmentsId',
                'search',
                'searchDepartments',
            ]);
    }

    public function updatedSelectDepartmentsId(){
        $this->departmentsSelected=Department::whereIn('id',$this->selectDepartmentsId)->pluck('name')->toArray();
    }
}