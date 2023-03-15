<?php

namespace App\Http\Livewire\Admin;

use App\Models\Common\Catalog;
use Livewire\Component;
use App\Models\Admin\SocialNetwork;
use App\Jobs\Admin\CreateSocialNetwork;
use App\Jobs\Admin\UpdateSocialNetwork;
use App\Jobs\Admin\DeleteSocialNetwork;

class SocialNetWorksForm extends Component
{
    public $idCompany;
    public $idSocialNetworkEdit;

    public string $url = '';
    public $type;

    protected array $rules = [
        'url' => 'required',
        'type' => 'required'
    ];

    public function render()
    {
        $social_networks = SocialNetwork::companyId($this->idCompany)->collect();
        $social_network_types = Catalog::catalogName('social_network_types')->first()->details;
        return view('livewire.admin.social-net-works-form', compact('social_network_types', 'social_networks'), ['company' => $this->idCompany]);
    }

    public function submit()
    {
        $this->validate();
        dispatch_now(new CreateSocialNetwork([
            'url' => $this->url,
            'type' => $this->type,
            'company_id' => $this->idCompany,
            'enabled' => 1
        ]));
        flash(trans_choice('messages.success.added', 1, ['type' => trans('general.social_network')]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }

    public function edit($idSocialNetwork)
    {
        $this->idSocialNetworkEdit = $idSocialNetwork;
        $socialNetwork = SocialNetwork::findOrFail($idSocialNetwork);
        $this->url = $socialNetwork->url;
        $this->type = $socialNetwork->type;
    }

    public function update()
    {
        $this->validate();
        dispatch_now(new UpdateSocialNetwork([
            'id' => $this->idSocialNetworkEdit,
            'url' => $this->url,
            'type' => $this->type
        ]));
        flash(trans_choice('messages.success.updated', 1, ['type' => trans('general.social_network')]))->success()->livewire($this);
        return redirect(route('companies.edit', ['company' => $this->idCompany]));
    }

    public function delete($idSocialNetwork)
    {
        dispatch_now(new DeleteSocialNetwork([
            'id' => $idSocialNetwork
        ]));
        flash(trans_choice('messages.success.deleted', 1, ['type' => trans('general.social_network')]))->success()->livewire($this);
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
        $this->url = '';
        $this->type = '';
    }

}