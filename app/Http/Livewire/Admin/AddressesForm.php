<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Admin\CreateAddress;
use App\Jobs\Admin\DeleteAddress;
use App\Jobs\Admin\UpdateAddress;
use App\Models\Admin\Address;
use Livewire\Component;

class AddressesForm extends Component
{
    public $idCompany;
    public $idAddressEdit;

    public $country;
    public $province;
    public $city;
    public $streetOne;
    public $streetTwo;
    public $streetThree;
    public $number;
    public $postalCode;
    public $latitude;
    public $longitude;

    protected $rules = [
        'country' => 'required',
        'province' => 'required',
        'city' => 'required',
        'streetOne' => 'required',
    ];

    public function render()
    {
        $addresses = Address::companyId($this->idCompany)->collect();
        return view('livewire.admin.addresses-form', compact('addresses'), ['company' => $this->idCompany]);
    }

    public function submit()
    {
        $this->validate();
        dispatch_now(new CreateAddress([
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'street_one' => $this->streetOne,
            'street_two' => $this->streetTwo,
            'street_three' => $this->streetThree,
            'number' => $this->number,
            'postal_code' => $this->postalCode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'enabled' => 1,
            'company_id' => $this->idCompany
        ]));
        flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.address', 1)]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }

    public function edit($idAddress)
    {
        $this->idAddressEdit = $idAddress;
        $address = Address::findOrFail($idAddress);
        $this->country = $address->country;
        $this->province = $address->province;
        $this->city = $address->city;
        $this->streetOne = $address->street_one;
        $this->streetTwo = $address->street_two;
        $this->streetThree = $address->street_three;
        $this->number = $address->number;
        $this->postalCode = $address->postal_code;
        $this->latitude = $address->latitude;
        $this->longitude = $address->longitude;
    }

    public function update()
    {
        $this->validate();
        dispatch_now(new UpdateAddress([
            'id' => $this->idAddressEdit,
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'street_one' => $this->streetOne,
            'street_two' => $this->streetTwo,
            'street_three' => $this->streetThree,
            'number' => $this->number,
            'postal_code' => $this->postalCode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ]));
        flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.address', 1)]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }

    public function delete($idAddress)
    {
        dispatch_now(new DeleteAddress(['id' => $idAddress]));
        flash(trans_choice('messages.success.deleted', 1, ['type' => trans_choice('general.address', 1)]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }

    public function open()
    {
        $this->resetInputFields();
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->country = '';
        $this->province = '';
        $this->city = '';
        $this->streetOne = '';
        $this->streetTwo = '';
        $this->streetThree = '';
        $this->number = '';
        $this->postalCode = '';
        $this->latitude = '';
        $this->longitude = '';
    }
}