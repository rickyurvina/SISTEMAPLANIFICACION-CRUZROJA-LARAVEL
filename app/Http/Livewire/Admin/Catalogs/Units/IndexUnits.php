<?php

namespace App\Http\Livewire\Admin\Catalogs\Units;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Units\DeleteUnitIndicator;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Traits\Jobs;
use function view;

class IndexUnits extends TableComponent
{
    use  Jobs;

    public $search = '';

    protected $listeners = ['unitCreated' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $units = IndicatorUnits::when($this->search, function ($query) {
            $query->where('name', 'iLIKE', '%' . $this->search . '%')
                ->orWhere('abbreviation', 'iLIKE', '%' . $this->search . '%');
        })->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.admin.catalogs.units.index-units', compact('units'));
    }

    public function cleanFilters()
    {
        $this->reset(
            [
                'search',
            ]);
    }

    public function delete($id)
    {
        $response = $this->ajaxDispatch(new DeleteUnitIndicator($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.units', 1)]))->success()->livewire($this);;
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }
}
