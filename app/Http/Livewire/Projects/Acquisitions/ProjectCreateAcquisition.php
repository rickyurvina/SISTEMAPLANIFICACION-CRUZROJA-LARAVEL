<?php

namespace App\Http\Livewire\Projects\Acquisitions;

use App\Models\Common\Catalog;
use App\Models\Common\CatalogPurchase;
use App\Traits\Jobs;
use Livewire\Component;
use \App\Jobs\Projects\ProjectCreateAcquisition as ProjectCreateAcquisitionJob;

class ProjectCreateAcquisition extends Component
{
    use Jobs;

    public $prj_project_id = null;

    public $acquisitionProductId;
    public $acquisitionDescription;
    public $acquisitionUnit;
    public $acquisitionQuantity;
    public $acquisitionPrice;
    public $acquisitionMode;
    public $acquisitionDate;

    public $units = [];
    public $types = [];

    protected $listeners = [
        'productChange',
        'loadCreateForm',
    ];

    public function mount($id)
    {
        $this->prj_project_id = $id;
    }

    public function render()
    {
        $this->units = Catalog::catalogName('measurement_unit')->first()->details;
        $this->types = Catalog::catalogName('acquisition_type')->first()->details;
        $this->emit('refreshDropdown');
        return view('livewire.projects.acquisitions.project-create-acquisition');
    }

    public function loadCreateForm($id)
    {
        $this->prj_project_id = $id;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleProjectCreateAcquisition');
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function createAcquisition()
    {
        $this->validate([
            'acquisitionProductId' => 'required',
            'acquisitionDescription' => 'required',
            'acquisitionUnit' => 'required',
            'acquisitionQuantity' => 'required|integer',
            'acquisitionPrice' => 'required|numeric',
            'acquisitionMode' => 'required',
            'acquisitionDate' => 'required',
        ]);

        $totalPrice = $this->acquisitionPrice * $this->acquisitionQuantity;
        $data = [
            'prj_project_id' => $this->prj_project_id,
            'product_id' => $this->acquisitionProductId,
            'description' => $this->acquisitionDescription,
            'unit_id' => $this->acquisitionUnit,
            'quantity' => $this->acquisitionQuantity,
            'price' => $this->acquisitionPrice,
            'total_price' => $totalPrice,
            'type_id' => $this->acquisitionMode,
            'date' => $this->acquisitionDate,
        ];

        $response = $this->ajaxDispatch(new ProjectCreateAcquisitionJob($data));

        $this->resetForm();
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.prj_acquisitions', 1)]))->success()->livewire($this);
            $this->emit('updateAcquisitionsList');
            $this->emit('toggleProjectCreateAcquisition');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function productChange()
    {
        $product = CatalogPurchase::find($this->acquisitionProductId);
        if ($product->unit_price) {
            $this->acquisitionPrice = $product->unit_price;
        }
    }
}
