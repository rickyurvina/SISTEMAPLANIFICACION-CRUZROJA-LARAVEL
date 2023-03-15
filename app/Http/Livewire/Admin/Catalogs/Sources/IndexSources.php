<?php

namespace App\Http\Livewire\Admin\Catalogs\Sources;

use App\Abstracts\TableComponent;
use App\Jobs\Indicators\Sources\DeleteSource;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Traits\Jobs;
use function view;

class IndexSources extends TableComponent
{
    use  Jobs;

    public $search = '';
    protected $listeners = ['sourceCreated' => 'render'];
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $sources = IndicatorSource::when($this->search, function ($query) {
            $query->where('name', 'iLIKE', '%' . $this->search . '%')
                ->orWhere('institution', 'iLIKE', '%' . $this->search . '%')
                ->orWhere('description', 'iLIKE', '%' . $this->search . '%')
                ->orWhere('type', 'iLIKE', '%' . $this->search . '%');
        })->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.admin.catalogs.sources.index-sources', compact('sources'));
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
        $response = $this->ajaxDispatch(new DeleteSource($id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.sources', 1)]))->success()->livewire($this);;
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }
}
