<?php

namespace App\Models\Budget;


use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Budget\Structure\BudgetGeneralExpensesStructure;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Comment;
use App\States\Transaction\Approved;
use App\States\Transaction\Draft;
use App\States\Transaction\TransactionState;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use LaravelIdea\Helper\App\Models\Budget\_IH_Account_C;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Transaction extends Model
{
    use HasStates,  Mediable, HasRecursiveRelationships{
        Mediable::newCollection insteadof HasRecursiveRelationships;
        HasRecursiveRelationships::newCollection as newCollection2;
        //TODO VERIFICAR FUNCIONAMIENTO DE NEWCOLLECTION POR COLISION CON LA FUNCION DE MEDIABLE
    }

    const TYPE_PROFORMA = 'PR';
    const TYPE_REFORM = 'RE';
    const TYPE_COMMITMENT = 'CO';
    const TYPE_CERTIFICATION = 'CE';
    const TYPE_ACCRUED = 'AS';

    const SOURCE_POA='sourcePoa';
    const SOURCE_PROJECT='sourceProject';
    const SOURCE_BUDGET='sourceBudget';

    const TYPE_BALANCE = [
        self::TYPE_PROFORMA,
        self::TYPE_ACCRUED,
        self::TYPE_COMMITMENT,
        self::TYPE_REFORM,
        self::TYPE_CERTIFICATION,
    ];
    const REFORM_TYPE_INCREMENT = 'Incremento';
    const REFORM_TYPE_DECREASE = 'Disminución';
    const REFORM_TYPE_TRANSFER = 'Transferencia';

    const REFORMS_TYPES =
        [
            self::REFORM_TYPE_INCREMENT,
            self::REFORM_TYPE_DECREASE,
            self::REFORM_TYPE_TRANSFER,
        ];

    const TYPES =
        [
            self::TYPE_PROFORMA => 'PROFORMA',
            self::TYPE_REFORM => 'REFORMA',
            self::TYPE_COMMITMENT => 'COMPROMISO',
            self::TYPE_CERTIFICATION => 'CERTIFICACIÓN',
        ];

    const REFORMS_TYPES_BG = [
        self::REFORM_TYPE_INCREMENT => 'badge-primary',
        self::REFORM_TYPE_DECREASE => 'badge-secondary',
        self::REFORM_TYPE_TRANSFER => 'badge-success',
    ];

    protected $table = 'bdg_transactions';

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes()
    {
    }

    protected $fillable = [
        'year',
        'type',
        'number',
        'description',
        'created_by',
        'approved_by',
        'approved_date',
        'company_id',
        'reform_type',
        'parent_id'
    ];

    protected $appends = ['balance', 'debits', 'credits', 'totalBalance', 'balanceIncomes', 'balanceExpenses'];

    protected $casts = [
        'status' => TransactionState::class,
        'approved_date' => 'date'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->description = strtoupper($model->description);
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionDetail::class)->withoutGlobalScopes();
    }

    public function structures()
    {
        return $this->hasMany(BudgetStructure::class, 'bdg_transaction_id');
    }

    public function getBalanceAttribute(): Money
    {
        $transactions = $this->transactions();
        if ($transactions->count() > 0) {
            $balance = $transactions->sum('debit') - $transactions->sum('credit');
        } else {
            $balance = 0;
        }

        return money($balance);
    }

    public function getDebitsAttribute(): Money
    {
        $transactions = $this->transactions();
        if ($transactions->count() > 0) {
            $debits = $transactions->sum('debit');
        } else {
            $debits = 0;
        }

        return money($debits);
    }

    public function getCreditsAttribute(): Money
    {
        $transactions = $this->transactions();

        if ($transactions->count() > 0) {
            $credits = $transactions->sum('credit');
        } else {
            $credits = 0;
        }

        return money($credits);
    }

    public function debit($value, string $description = null, int $accountId = null): TransactionDetail
    {
        $value = is_a($value, Money::class)
            ? $value
            : money_parse_by_decimal($value, Money::getDefaultCurrency());
        return $this->post(null, $value, $description, $accountId);
    }

    public function credit($value, string $description = null, int $accountId = null): TransactionDetail
    {
        $value = is_a($value, Money::class)
            ? $value
            : money_parse_by_decimal($value, Money::getDefaultCurrency());
        return $this->post($value, null, $description, $accountId);
    }


    public function debitUpdate($value, string $description = null, int $transactionDetailId = null): TransactionDetail
    {
        $value = is_a($value, Money::class)
            ? $value
            : money_parse_by_decimal($value, Money::getDefaultCurrency());
        return $this->updateTransaction($transactionDetailId, null, $value, $description);
    }

    public function creditUpdate($value, string $description = null, int $transactionDetailId = null): TransactionDetail
    {
        $value = is_a($value, Money::class)
            ? $value
            : money_parse_by_decimal($value, Money::getDefaultCurrency());
        return $this->updateTransaction($transactionDetailId, $value, null, $description);
    }

    private function getNextNumber()
    {
        return $this->transactions()->max('number') + 1;
    }

    private function post(Money $credit = null, Money $debit = null, string $description = null, int $account_id = null): TransactionDetail
    {
        $transaction = new TransactionDetail;
        $transaction->number = $this->getNextNumber();
        $transaction->credit = $credit ? $credit->getAmount() : null;
        $transaction->debit = $debit ? $debit->getAmount() : null;
        $transaction->description = $description;
        $transaction->account_id = $account_id;
        $this->transactions()->save($transaction);
        return $transaction;
    }

    private function updateTransaction(int $transactionDetailId, Money $credit = null, Money $debit = null, string $description = null): TransactionDetail
    {
        $transaction = TransactionDetail::find($transactionDetailId);
        $transaction->credit = $credit ? $credit->getAmount() : null;
        $transaction->debit = $debit ? $debit->getAmount() : null;
        $transaction->description = $description;
        $this->transactions()->save($transaction);
        return $transaction;
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function getBalanceIncomesAttribute(): Money
    {
        $incomes = TransactionDetail::with(['account', 'transaction'])->whereHas('account', function ($query) {
            $query->where([
                ['type', Account::TYPE_INCOME],
                ['year', $this->year]
            ]);
        })->whereHas('transaction', function ($q) {
            $q->where('type', Transaction::TYPE_PROFORMA)->where('year', $this->year)
                ->whereState('status', Approved::class);
        });

        $total = 0;
        foreach ($incomes->get() as $income) {
            $total += $income->account->balance->getAmount();
        }
        $total = money($total);
        return $total;
    }

    public function getBalanceExpensesAttribute(): Money
    {
        $expenses = TransactionDetail::with(['account', 'transaction'])->whereHas('account', function ($query) {
            $query->where([
                ['type', Account::TYPE_EXPENSE],
                ['year', $this->year]
            ]);
        })->whereHas('transaction', function ($q) {
            $q->where('type', Transaction::TYPE_PROFORMA)->where('year', $this->year)
                ->whereState('status', Approved::class);
        });
        $total = 0;
        foreach ($expenses->get() as $expens) {
            $total += $expens->account->balance->getAmount();
        }
        $total = money($total);
        return $total;
    }


    public function getBalanceIncomeDraftAttribute($status): Money
    {
        $expenses = TransactionDetail::with(['account', 'transaction'])->whereHas('account', function ($query) {
            $query->where([
                ['type', Account::TYPE_INCOME],
                ['year', $this->year]
            ]);
        });
        $total = 0;
        foreach ($expenses->get() as $expens) {
            $total += $expens->account->balanceDraft($status)->getAmount();
        }
        $total = money($total);
        return $total;
    }

    public function getBalanceExpenseDraftAttribute($status): Money
    {
        $expenses = TransactionDetail::with(['account', 'transaction'])->whereHas('account', function ($query) {
            $query->where([
                ['type', Account::TYPE_EXPENSE],
                ['year', $this->year]
            ]);
        });
        $total = 0;
        foreach ($expenses->get() as $expens) {
            $total += $expens->account->balanceDraft($status)->getAmount();
        }
        $total = money($total);
        return $total;
    }

    public function getBalanceIncome($status)
    {
        if ($this->status instanceof Approved) {
            return $this->getBalanceIncomesAttribute();
        } else {
            return $this->getBalanceIncomeDraftAttribute($status);
        }
    }

    public function getBalanceExpense($status)
    {
        if ($this->status instanceof Approved) {
            return $this->getBalanceExpensesAttribute();
        } else {
            return $this->getBalanceExpenseDraftAttribute($status);
        }
    }

    public function budgetGeneralExpensesStructures(): HasMany
    {
        return $this->hasMany(BudgetGeneralExpensesStructure::class, 'bdg_transaction_id');
    }

    /**
     * @param $type
     * @param int|null $id
     * @return Account|_IH_Account_C
     */
    public function accounts($type, int $id = null)
    {
        return Account::where('type', $type)
            ->where('year', $this->year)
            ->when($id != null, function ($q) use ($id) {
                $q->where('id', $id);
            })->get();
    }

    /**
     * @param int|null $id
     * @return int
     */
    public function incomesInitialAssigne(int $id = null): int
    {
        $accounts = $this->accounts(Account::TYPE_INCOME, $id);
        $totalIncomesInitialAssignee = 0;
        foreach ($accounts as $income) {
            if ($this->status instanceof Approved) {
                $totalIncomesInitialAssignee += $income->balancePr->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalIncomesInitialAssignee += $income->balancePrDraft->getAmount();
            }
        }

        return $totalIncomesInitialAssignee;
    }

    /**
     * @param int|null $id
     * @return int
     */
    public function incomesReforms(int $id = null): int
    {
        $accounts = $this->accounts(Account::TYPE_INCOME, $id);
        $totalReforms = 0;
        foreach ($accounts as $income) {
            if ($this->status instanceof Approved) {
                $totalReforms += $income->balanceRe->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalReforms += $income->balanceReDraft->getAmount();
            }
        }

        return $totalReforms;
    }

    /**
     * @param int|null $id
     * @return Money
     */
    public function codedBalanceBudgetIncomes(int $id = null): Money
    {
        //asignacio inicial - reformas
        $totalIncomesInitialAssignee = $this->incomesInitialAssigne($id);
        $totalReforms = $this->incomesReforms($id);
        $result = $totalIncomesInitialAssignee + $totalReforms;
        $result = money($result);
        return $result;
    }

    /**
     * @param int|null $id
     * @return int
     */
    public function expensesInitialAssigne(int $id = null): int
    {
        $accounts = $this->accounts(Account::TYPE_EXPENSE, $id);
        $totalIncomesInitialAssignee = 0;
        foreach ($accounts as $expense) {
            if ($this->status instanceof Approved) {
                $totalIncomesInitialAssignee += $expense->balancePr->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalIncomesInitialAssignee += $expense->balancePrDraft->getAmount();
            }
        }

        return $totalIncomesInitialAssignee;
    }

    /**
     * @param int|null $id
     * @return int
     */
    public function expensesReforms(int $id = null): int
    {
        $accounts = $this->accounts(Account::TYPE_EXPENSE, $id);
        $totalReforms = 0;
        foreach ($accounts as $expense) {
            if ($this->status instanceof Approved) {
                $totalReforms += $expense->balanceRe->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalReforms += $expense->balanceReDraft->getAmount();
            }
        }

        return $totalReforms;
    }


    /**
     * @param int|null $id
     * @return Money
     */
    public function expenseCertifications(int $id = null): Money
    {
        $accounts = $this->accounts(Account::TYPE_EXPENSE, $id);
        $totalReforms = 0;
        foreach ($accounts as $expense) {
            if ($this->status instanceof Approved) {
                $totalReforms += $expense->getBalanceCeApprovedAttribute($this->id)->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalReforms += $expense->getBalanceCeDraftAttribute($this->id)->getAmount();
            }
        }

        return money($totalReforms);
    }

    /**
     * @param int|null $id
     * @return Money
     */
    public function expenseCommitments(int $id = null): Money
    {
        $accounts = $this->accounts(Account::TYPE_EXPENSE, $id);
        $totalReforms = 0;
        foreach ($accounts as $expense) {
            if ($this->status instanceof Approved) {
                $totalReforms += $expense->getBalanceCmAttribute($this->id)->getAmount();
            } else if ($this->status instanceof Draft) {
                $totalReforms += $expense->getBalanceCmDraftAttribute($this->id)->getAmount();
            }
        }

        return money($totalReforms);
    }

    /**
     * @param int|null $id
     * @return Money
     */
    public function codedBalanceBudgetExpenses(int $id = null): Money
    {
        //asignacio inicial - reformas
        $totalExpensesInitialAssignee = $this->expensesInitialAssigne($id);
        $totalExpensesReforms = $this->expensesReforms($id);
        $result = $totalExpensesInitialAssignee + $totalExpensesReforms;
        $result = money($result);
        return $result;
    }

    public function getTotalBalanceAttribute(): Money
    {
        return money($this->codedBalanceBudgetIncomes()->getAmount() - $this->codedBalanceBudgetExpenses()->getAmount());
    }

}
