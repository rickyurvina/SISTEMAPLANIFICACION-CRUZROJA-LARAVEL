<?php

namespace App\Http\Livewire\Poa\Catalogs;

use App\Jobs\Poa\UpdatePoaActivityTemplate;
use App\Models\Poa\PoaActivityTemplate;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function flash;
use function redirect;
use function session;
use function view;

class PoaCatalogActivityEditModal extends Component
{
    use Jobs;

    public $catalog;
    public $code;
    public $name;
    public $cost;
    public $impact;
    public $complexity;
    public $activityId;

    protected $listeners = [
        'loadCatActEditForm' => 'edit'
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
                        Rule::unique('poa_activity_templates')->where('company_id', session('company_id'))->where('deleted_at', null)->ignore($this->activityId)
                    ],
                'cost' => 'nullable|numeric',
                'impact' => 'required',
                'complexity' => 'required',
            ];
    }

    public function edit($id)
    {

        $this->resetForm();
        if ($id) {
            $catActivity = PoaActivityTemplate::find($id);

            $this->activityId = $catActivity->id;
            $this->code = $catActivity->code;
            $this->name = $catActivity->name;
            $this->cost = $catActivity->cost;
            $this->impact = $catActivity->impact;
            $this->complexity = $catActivity->complexity;

            $this->catalog = $catActivity;
        }
    }

    public function update()
    {

        $this->validate();
        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'cost' => $this->cost,
            'impact' => $this->impact,
            'complexity' => $this->complexity,
            'company_id' => session('company_id'),
        ];

        $aux = PoaActivityTemplate::where('code', $this->code)->where('id', '<>', $this->catalog->id)->first();

        if ($aux == null) {

            $response = $this->ajaxDispatch(new UpdatePoaActivityTemplate($this->catalog, $data));

            if ($response['success']) {
                flash(trans_choice('messages.success.updated', 0, ['type' => trans('general.poa_activity_catalog_create')]))->success();
                return redirect()->route('poa.manage_catalog_activities');

            } else {
                flash($response['message'])->error()->livewire($this);
            }
        } else {
            flash("El cóigo de aplicación ya existe")->error()->livewire($this);
        }
    }

    public function render()
    {
        return view('livewire.poa.catalogs.poa-catalog-activity-edit-modal');
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

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleCatActivityEditModal');
    }
}
