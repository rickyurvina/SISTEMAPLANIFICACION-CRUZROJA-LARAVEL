<?php

namespace App\Http\Livewire\Poa;

use App\Models\Budget\Transaction;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\States\TransactionDetails\Approved;
use App\States\TransactionDetails\Draft;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PoaBudgetIndex extends Component
{
    use WithPagination;

    public $poa;
    public $transaction;
    public $search = '';
    public $account;
    public $typeBudgetIncome = true;
    public $typeBudgetExpense;
    public $levelIncomeSelected;

    protected $listeners = ['updateIndexBudget' => 'render'];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount(int $poaId)
    {
        $this->poa = Poa::with(['programs'])->find($poaId);
        $this->transaction = Transaction::where('year', $this->poa->year)
            ->where('type', Transaction::TYPE_PROFORMA)->withoutGlobalScopes()->first();
    }

    public function render()
    {
        $activities = PoaActivity::with([
            'accounts.transactionsPrDraft',
        ])
            ->when(!empty($this->search), function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('code', 'iLike', '%' . $this->search . '%')
                        ->orWhere('name', 'iLike', '%' . $this->search . '%');
                });
            })->whereIn('poa_program_id', $this->poa->programs->pluck('id')->toArray())
            ->paginate(setting('default.list_limit', '25'));
        return view('livewire.poa.poa-budget-index', compact('activities'));
    }

    public function clearFilters()
    {
        $this->search = '';
    }

    public function approveAllBudget()
    {
        $activities = PoaActivity::with([
            'accounts.transactionsPrDraft',
        ])->whereIn('poa_program_id', $this->poa->programs->pluck('id')->toArray())
            ->get();

        $transactionsDetails = $activities->pluck('accounts')
            ->collapse()->pluck('transactionsPrDraft')
            ->collapse()->where('status', Draft::label());

        if ($transactionsDetails->count()) {
            try {
                DB::beginTransaction();
                foreach ($transactionsDetails as $transactionsDetail) {
                    $transactionsDetail->status = Approved::label();
                    $transactionsDetail->approved_by = user()->id;
                    $transactionsDetail->save();
                }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                flash($exception->getMessage())->error()->livewire($this);
            }
        } else {
            flash('No existen partidas presupuestarias por aprobar')->warning()->livewire($this);
        }
    }
}
