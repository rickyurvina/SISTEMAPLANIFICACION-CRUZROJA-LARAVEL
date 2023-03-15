<?php

namespace App\Http\Livewire\Projects\Configuration;

use App\Jobs\Projects\ProjectCreateShoppingJob;
use App\Traits\Jobs;
use Livewire\Component;

class PublicPurchasesCreateForm extends Component
{
    use Jobs;

    public string $code = "";
    public string $name = "";
    public string $description = "";
    public $unitPrice;

    protected array $rules = [
        'code' => 'required',
        'name' => 'required',
        'description' => 'required',
        'unitPrice' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $data = [
            "code" => $this->code,
            "name" => $this->name,
            "description" => $this->description,
            "unit_price" => $this->unitPrice
        ];

        $response = $this->ajaxDispatch(new ProjectCreateShoppingJob($data));

        if ($response['success']) {
            $this->clean();
            $this->emit('LoadPublicPurchases');
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.shopping', 1)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
        $this->clean();
        $this->emit('LoadPublicPurchases');
        $this->emit('togglePublicPurchaseAddModal');
    }

    public function clean()
    {
        $this->code = "";
        $this->name = "";
        $this->description = "";
        $this->unitPrice = "";
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('togglePublicPurchaseAddModal');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.projects.configuration.public-purchases-create-form');
    }
}
