<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Admin\CreateContact;
use App\Models\Admin\Contact;
use App\Models\Admin\Department;
use App\Models\Common\Catalog;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use SebastianBergmann\Environment\Console;

class ContactCreateModal extends Component
{
    use  Jobs;

    public $name = null;
    public $email = null;
    public $phone = null;
    public $projectId = null;
    public $businessPhone = null;
    public $personalNotes = null;

    protected $listeners = [
        'resetForm'
    ];

    protected $rules = [
        'name' => 'required | max:255',
        'email' => 'required | email',
        'phone' => ['required', 'regex:/[0-9]([0-9]|-(?!-))+/', 'min:7', 'max:13'],
    ];

    public function mount($projectId = null)
    {
        $this->projectId = $projectId;
    }

    public function render()
    {
        return view('livewire.admin.contact-create-modal');
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
                'name',
                'email',
                'phone',
                'personalNotes',
            ]
        );
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255|unique:users',
            'phone' => ['required', 'regex:/[0-9]([0-9]|-(?!-))+/', 'min:7', 'max:13']
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'personal_phone' => $this->phone,
            'personal_notes' => $this->personalNotes,
            'password' => '12345678',
            'enabled' => 0,
        ];

        $response = $this->ajaxDispatch(new CreateContact($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => trans_choice('general.contacts', 1)]))->success()->livewire($this);
            $this->closeModal();
        } else {
            flash(trans_choice('messages.error.added', 0, ['type' => trans_choice('general.contacts', 1)]))->error()->livewire($this);
        }

    }

    public function closeModal()
    {
        $this->resetForm();
        $this->emit('toggleContactAddModal');
        $this->emit('updateModalCreateStakeholder', $this->projectId);
    }

}
