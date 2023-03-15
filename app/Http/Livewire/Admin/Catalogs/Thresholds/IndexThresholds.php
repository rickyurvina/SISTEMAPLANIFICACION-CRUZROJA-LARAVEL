<?php

namespace App\Http\Livewire\Admin\Catalogs\Thresholds;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Thresholds\DeleteThreshold;
use App\Models\Indicators\Threshold\Threshold;
use App\Traits\Jobs;
use function view;

class IndexThresholds extends TableComponent
{
    use  Jobs;

    public $search = '';
    protected $listeners = ['thresholdCreated' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $thresholds = Threshold::when($this->search, function ($query) {
            $query->where('name', 'iLIKE', '%' . $this->search . '%');
        })->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.admin.catalogs.thresholds.index-thresholds',compact('thresholds'));
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
        $response = $this->ajaxDispatch(new DeleteThreshold($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.thresholds', 1)]))->success()->livewire($this);;
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }
}
