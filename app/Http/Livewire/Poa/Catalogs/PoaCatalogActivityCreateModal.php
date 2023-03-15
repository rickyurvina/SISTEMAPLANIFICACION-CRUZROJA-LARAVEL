<?php

namespace App\Http\Livewire\Poa\Catalogs;

use App\Jobs\Poa\CreatePoaActivityTemplate;
use App\Traits\Jobs;
use Beta\Microsoft\Graph\Model\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function flash;
use function redirect;
use function session;
use function view;

// use Illuminate\View\Component;

class PoaCatalogActivityCreateModal extends Component
{
    use Jobs;

    public $code;
    public $name;
    public $cost;
    public $impact;
    public $complexity;

    protected $listeners = [
        'loadCatActAddForm' => 'render',
    ];

    public function rules()
    {

        return
            [
                'name' => 'required|string',
                'code' =>
                    [
                        'required',
                        'string',
                        Rule::unique('poa_activity_templates')->where('company_id', session('company_id'))->where('deleted_at',null)
                    ],
                'cost' => 'nullable|numeric',
                'impact' => 'required',
                'complexity' => 'required',
            ];
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(
            [
                'code',
                'name',
                'cost',
                'impact',
                'complexity',
            ]
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.poa.catalogs.poa-catalog-activity-create-modal');
    }

    public function submit()
    {

        $this->validate();
        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'cost' => $this->cost,
            'impact' => $this->impact ?? 0,
            'complexity' => $this->complexity ?? 0,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new CreatePoaActivityTemplate($data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans('general.poa_activity_catalog_create')]))->success();
            return redirect()->route('poa.manage_catalog_activities');

        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleCatActivityAddModal');
    }
}
