<?php

namespace App\Http\Livewire\Projects\Configuration;

use App\Models\Common\CatalogPurchase;
use Livewire\Component;

class PublicPurchasesList extends Component
{

    public $search = '';

    protected $listeners = ['LoadPublicPurchases' => 'render'];

    public function delete($id)
    {
        $catalogPurchase = CatalogPurchase::find($id);
        if (count($catalogPurchase->acquisitions) > 0) {
            flash(__('messages.error.delete'))->error()->livewire($this);
        } else {
            $catalogPurchase->delete();
            flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.shopping', 1)]))->success()->livewire($this);
        }
        $this->render();
    }

    public function render()
    {
        if ($this->search != '') {
            $search = $this->search;
            $public_purchases = CatalogPurchase::where('name', 'iLIKE', '%' . $search . '%')->orderByDesc('id')->paginate(15);
        } else {
            $public_purchases = CatalogPurchase::orderByDesc('id')->paginate(15);
        }
        return view('livewire.projects.configuration.public-purchases-list', compact('public_purchases'));
    }

    public function updatedSearch()
    {
        $this->render();
    }

}
