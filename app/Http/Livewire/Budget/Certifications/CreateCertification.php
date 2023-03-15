<?php

namespace App\Http\Livewire\Budget\Certifications;

use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\States\Transaction\Approved;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CreateCertification extends Component
{
    public $transaction;
    public $transactionPr;
    public $poa;
    public $projects;
    public $search = '';
    public $viewPoa = false;
    public $viewProject = false;
    public $viewProjectActivity = false;
    public $viewPoaActivity = false;
    public $poaActivity;
    public $projectActivity;
    public $expensesPoa;
    public $expensesProject;
    public string $description = '';
    public array $certificationsValues = [];
    public array $selectedProjects = [];

    protected $rules = [
        'description' => 'required',
        'certificationsValues.*' => 'numeric|min:0'
    ];

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->transactionPr = Transaction::where('year',$transaction->year)->whereStatus(Approved::label())->first();
        $this->poa = Poa::where('year', $this->transaction->year)->first();
        $this->projects = Project::whereIn('phase', [Project::PHASE_PLANNING, Project::PHASE_IMPLEMENTATION])->get();
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        if (isset($this->poa)) {
            $activitiesPoa = PoaActivity::whereHas('program', function (Builder $query) {
                $query->where('poa_id', $this->poa->id);
            })
                ->when(!empty($this->search), function (Builder $query) {
                    $query->where(function ($q) {
                        $q->where('code', 'iLike', '%' . $this->search . '%')
                            ->orWhere('name', 'iLike', '%' . $this->search . '%');
                    });
                })
                ->orderBy('plan_detail_id', 'asc')
                ->orderBy('measure_id', 'asc')
                ->with(['responsible', 'measure', 'planDetail', 'program'])
                ->withCount('comments')
                ->get()->filter(function ($activity) {
                    return $activity->getTotalBudget($this->transactionPr)->getAmount() > 0;
                });
        }
        $activitiesProject = Task::whereHas('project', function ($query) {
            $query->whereIn('phase', [Project::PHASE_PLANNING, Project::PHASE_IMPLEMENTATION]);
        })->when(!empty($this->search), function (Builder $query) {
            $query->where(function ($q) {
                $q->where('code', 'iLike', '%' . $this->search . '%')
                    ->orWhere('text', 'iLike', '%' . $this->search . '%');
            });
        })->when(count($this->selectedProjects) > 0, function (Builder $query) {
            $query->whereIn('project_id', $this->selectedProjects);
        })->orderBy('project_id', 'asc')
            ->where('type', 'task')
            ->get()->filter(function ($activity) {
                return $activity->getTotalBudget($this->transactionPr)->getAmount() > 0;
            });;
        return view('livewire.budget.certifications.create-certification', compact('activitiesPoa', 'activitiesProject'));
    }

    public function loadPoaActivity(int $activityId)
    {
        $this->poaActivity = PoaActivity::find($activityId);

        $expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $activityId],
                ['accountable_type', PoaActivity::class],
                ['year', $this->transaction->year],
            ]
        );
        if ($expenses->count() > 0) {
            $this->expensesPoa = $expenses->get();
            $this->viewPoa = false;
            $this->viewPoaActivity = true;
        } else {
            flash('No tiene partidas asignadas')->warning()->livewire($this);
        }
    }

    public function loadProjectActivity(int $activityId)
    {
        $this->viewPoa = false;
        $this->viewPoaActivity = false;
        $this->projectActivity = Task::find($activityId);

        $expenses = Account::where([
                ['type', Account::TYPE_EXPENSE],
                ['accountable_id', $activityId],
                ['accountable_type', Task::class],
                ['year', $this->transaction->year],
            ]
        );

        if ($expenses->count() > 0) {
            $this->expensesProject = $expenses->get();
            $this->viewProject = false;
            $this->viewProjectActivity = true;
        } else {
            flash('No tiene partidas asignadas')->warning()->livewire($this);
        }
    }

    public function closeActivity()
    {
        $this->viewPoaActivity = false;
        $this->reset(['poaActivity']);
        $this->viewPoa = true;
    }

    public function saveCertification()
    {
        $this->validate();
        if (count($this->certificationsValues) === 0) {
            flash('No se han asignado valores a la certificación')->warning()->livewire($this);
        } else {
            self::updatedCertificationsValues();
            $number = Transaction::query()->where([
                    ['year', '=', $this->transaction->year],
                    ['type', '=', Transaction::TYPE_CERTIFICATION],
                ])->max('number') + 1;
            $newTransaction = Transaction::create([
                'year' => $this->transaction->year,
                'description' => $this->description,
                'type' => Transaction::TYPE_CERTIFICATION,
                'number' => $number,
                'created_by' => user()->id,
                'company_id' => session('company_id'),
            ]);
            foreach ($this->certificationsValues as $index => $item) {
                if ($this->expensesPoa) {
                    $expense = $this->expensesPoa->find($index);
                } else {
                    $expense = $this->expensesProject->find($index);
                }
                $newTransaction->debit($item, $this->description, $expense->id);
            }
            flash('Guardado Exitosamente')->success();
            return redirect()->route('budgets.certifications', $this->transaction);
        }
    }

    public function updatedCertificationsValues()
    {
        foreach ($this->certificationsValues as $index => $item) {
            if ($this->expensesPoa) {
                $expense = $this->expensesPoa->find($index);
            } else {
                $expense = $this->expensesProject->find($index);
            }
            if ($expense->balance->getAmount() / 100 < $item) {
                flash('El valor no puede ser mayor al valor por comprometer')->warning()->livewire($this);
                unset($this->certificationsValues[$index]);
            }
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedProjects = [];
    }

    public function updated($name, $value)
    {
        if ($name == 'viewPoa') {
            $this->reset(['expensesProject', 'viewProject', 'viewPoaActivity', 'viewProjectActivity', 'certificationsValues']);
        }
        if ($name == 'viewProject') {
            $this->reset(['expensesPoa', 'viewPoa', 'viewPoaActivity', 'viewProjectActivity', 'certificationsValues']);
        }
        if ($name == 'viewPoaActivity') {
            $this->reset(['viewProjectActivity', 'certificationsValues', 'expensesProject']);
        }
        if ($name == 'viewProjectActivity') {
            $this->reset(['viewPoaActivity', 'certificationsValues', 'expensesPoa']);
        }
    }
}
