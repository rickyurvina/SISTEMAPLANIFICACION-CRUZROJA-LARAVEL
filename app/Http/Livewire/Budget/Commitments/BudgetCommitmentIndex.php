<?php

namespace App\Http\Livewire\Budget\Commitments;

use App\Models\Budget\Transaction;
use App\States\Transaction\Override;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetCommitmentIndex extends Component
{
    use WithPagination;

    public $certification;
    public $stateSelect;
    public $reformSelect;
    public $start_date;
    public $end_date;
    public $countRegisterSelect = 25;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = ['refreshCertifications' => '$refresh'];

    public function mount(int $certificationId)
    {
        $this->certification = Transaction::with('children')->find($certificationId);
    }

    public function render()
    {
        $commitments = $this->certification->children()->orderBy('number', 'desc')->where('year', $this->certification->year)
            ->when($this->stateSelect, function ($query) {
                $query->where('status', $this->stateSelect);
            })->search('description', $this->search)
            ->paginate(setting('default.list_limit', $this->countRegisterSelect));
        return view('livewire.budget.commitments.budget-commitment-index', compact('commitments'));
    }

    public function overrideTransaction(int $id)
    {
        $certification = Transaction::find($id);
        $certification->status = Override::label();
        $certification->save();
    }

    public function clearFilters()
    {
        $this->reset(['stateSelect', 'reformSelect', 'countRegisterSelect']);
    }

}
