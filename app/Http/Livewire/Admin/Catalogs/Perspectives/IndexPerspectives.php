<?php

namespace App\Http\Livewire\Admin\Catalogs\Perspectives;

use App\Abstracts\TableComponent;
use App\Jobs\Admin\DeletePerspective;
use App\Jobs\Indicators\Units\DeleteUnitIndicator;
use App\Models\Admin\Perspective;
use App\Traits\Jobs;
use function view;

class IndexPerspectives extends TableComponent
{
    use  Jobs;

    public $search = '';

    protected $listeners = ['perspectiveCreated' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function render()
    {
        $perspectives = Perspective::when($this->search, function ($query) {
            $query->where('name', 'iLIKE', '%' . $this->search . '%');
        })->when($this->sortField, function ($q) {
            $q->orderBy($this->sortField, $this->sortDirection);
        })->paginate(setting('default.list_limit', '25'));
        return view('livewire.admin.catalogs.perspectives.index-perspectives',compact('perspectives'));
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
        $response = $this->ajaxDispatch(new DeletePerspective($id));

        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.perspective', 1)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }
}
