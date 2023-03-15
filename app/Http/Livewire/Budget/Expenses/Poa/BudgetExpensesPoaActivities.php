<?php

namespace App\Http\Livewire\Budget\Expenses\Poa;

use App\Models\Budget\Transaction;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class BudgetExpensesPoaActivities extends Component
{
    public $transaction;

    public int $idPoa;

    public $search = '';

    public $programs;

    public array $selectedPrograms = [];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $poa = Poa::where('year', $this->transaction->year)->first();
        if ($poa) {
            $this->idPoa = $poa->id;
            $this->loadPrograms();
        }

    }

    public function render()
    {
        $total = 0;
        if (isset($this->idPoa)) {
            $activities = PoaActivity::with(
                [
                    'responsible',
                    'planDetail',
                    'program',
                    'measure',
                ])
                ->whereHas('program', function (Builder $query) {
                    $query->where('poa_id', $this->idPoa);
                })
                ->when(!empty($this->search), function (Builder $query) {
                    $query->where(function ($q) {
                        $q->where('code', 'iLike', '%' . $this->search . '%')
                            ->orWhere('name', 'iLike', '%' . $this->search . '%');
                    });
                })
                ->when(count($this->selectedPrograms) > 0, function (Builder $query) {
                    $query->whereIn('poa_program_id', $this->selectedPrograms);
                })
                ->orderBy('plan_detail_id', 'asc')
                ->orderBy('measure_id', 'asc')
                ->with(['responsible', 'planDetail', 'program'])
                ->withCount('comments');

            foreach ($activities->get() as $activity) {
                $total += $activity->getTotalBudget($this->transaction)->getAmount();
            }
            $total = money($total);
            $activities = $activities->paginate(setting('default.list_limit', '25'));
        }

        return view('livewire.budget.expenses.poa.budget-expenses-poa-activities', compact('total'))->with('activities', $activities ?? null);
    }

    public function loadPrograms()
    {
        $this->programs = PoaProgram::with(['planDetail'])->where('poa_id', $this->idPoa)->get();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedPrograms = [];
    }
}
