<?php

namespace App\Http\Livewire\Projects\Acquisitions;

use App\Jobs\Projects\ProjectUpdateAcquisition;
use App\Models\Common\Catalog;
use App\Models\Common\CatalogPurchase;
use App\Traits\Jobs;
use Livewire\Component;
use App\Models\Projects\ProjectAcquisitions as ProjectAcquisitionsModel;

class ProjectEditAcquisition extends Component
{
    use Jobs;

    public $prj_project_edit_id = null;

    public $acquisitionId;
    public $acquisitionEditProductId;
    public $acquisitionEditDescription;
    public $acquisitionEditUnit;
    public $acquisitionEditQuantity;
    public $acquisitionEditPrice;
    public $acquisitionEditMode;
    public $acquisitionEditDate;

    public $unitsEdit = [];
    public $typesEdit = [];

    protected $listeners = [
        'loadForm',
        'productEditChange',
    ];

    public function mount($id)
    {
        $this->prj_project_edit_id = $id;
    }

    public function render()
    {
        $this->unitsEdit = Catalog::catalogName('measurement_unit')->first()->details;
        $this->typesEdit = Catalog::catalogName('acquisition_type')->first()->details;
        return view('livewire.projects.acquisitions.project-edit-acquisition');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleProjectEditAcquisition');
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function loadForm($id)
    {
        $acquisition = ProjectAcquisitionsModel::find($id);
        $this->acquisitionId = $id;
        $this->acquisitionEditProductId = $acquisition->product_id;
        $this->acquisitionEditDescription = $acquisition->description;
        $this->acquisitionEditUnit = $acquisition->unit_id;
        $this->acquisitionEditQuantity = $acquisition->quantity;
        $this->acquisitionEditPrice = $acquisition->price;
        $this->acquisitionEditMode = $acquisition->type_id;
        $this->acquisitionEditDate = $acquisition->date;
        $product = CatalogPurchase::find($this->acquisitionEditProductId);
        $this->dispatchBrowserEvent('loadProduct', ['id' => $this->acquisitionEditProductId, 'description' => $product->name]);
    }

    public function productEditChange()
    {
        $product = CatalogPurchase::find($this->acquisitionEditProductId);
        if ($product->unit_price) {
            $this->acquisitionEditPrice = $product->unit_price;
        }
    }

    public function updateAcquisition()
    {
        $this->validate([
            'acquisitionEditProductId' => 'required',
            'acquisitionEditDescription' => 'required',
            'acquisitionEditUnit' => 'required',
            'acquisitionEditQuantity' => 'required|numeric',
            'acquisitionEditPrice' => 'required|numeric',
            'acquisitionEditDate' => 'required',
            'acquisitionEditMode' => 'required',
        ]);

        $totalEditPrice = $this->acquisitionEditPrice * $this->acquisitionEditQuantity;
        $data = [
            'id' => $this->acquisitionId,
            'prj_project_id' => $this->prj_project_edit_id,
            'product_id' => $this->acquisitionEditProductId,
            'description' => $this->acquisitionEditDescription,
            'unit_id' => $this->acquisitionEditUnit,
            'quantity' => $this->acquisitionEditQuantity,
            'price' => $this->acquisitionEditPrice,
            'total_price' => $totalEditPrice,
            'type_id' => $this->acquisitionEditMode,
            'date' => $this->acquisitionEditDate,
        ];

        $response = $this->ajaxDispatch(new ProjectUpdateAcquisition($data));

        $this->resetForm();
        $this->reset();
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.prj_acquisitions', 1)]))->success()->livewire($this);
            $this->emit('updateAcquisitionsList');
            $this->emit('toggleProjectEditAcquisition');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }
}
