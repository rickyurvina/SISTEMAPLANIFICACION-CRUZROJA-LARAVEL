<?php

namespace App\Models\Budget;

use App\Abstracts\Model;
use App\States\Transaction\Approved;
use App\States\Transaction\Draft;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Account extends Model
{

    const TYPE_INCOME = 1;
    const TYPE_EXPENSE = 2;

    const TYPES = [
        self::TYPE_INCOME => 'Ingreso',
        self::TYPE_EXPENSE => 'Gasto',
    ];

    protected $table = 'bdg_accounts';

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes()
    {
    }

    protected $casts = ['settings' => 'array'];

    protected $fillable =
        [
            'year',
            'type',
            'code',
            'name',
            'description',
            'parent_id',
            'company_id',
            'settings',
            'accountable_type',
            'accountable_id',
            'is_new',
        ];

    protected $appends = ['balance', 'balancePr', 'balancePrDraft', 'balanceRe', 'balanceReDraft', 'balanceCm', 'balanceCmDraft', 'balanceAs','balanceAsDraft', 'balanceCeApproved', 'balanceCeDraft'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->name = strtoupper($model->name);
            $model->code = strtoupper($model->code);
            $model->description = strtoupper($model->description);
            $transaction = Transaction::where('year', $model->year)->where('type', Transaction::TYPE_PROFORMA)->first();
            if ($transaction->status instanceof Approved) {
                $model->is_new = true;
                $model->save();
            }
        });
        static::updating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->code = strtoupper($model->code);
            $model->description = strtoupper($model->description);
        });

        static::deleting(function ($model) {
            $transaction = Transaction::where('year', $model->year)->where('type', Transaction::TYPE_PROFORMA)->first();
            if ($transaction->status instanceof Approved) {
                throw new \Exception('Presupuesto Aprobado, no se puede eliminar...');
            }
        });
    }

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeIncomes(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_INCOME);
    }

    public function scopeExpenses(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_EXPENSE);
    }

    /**
     * @return HasMany
     */
    public function transactionsDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes();
    }

    /**
     * @return Builder|HasMany
     */
    public function transactions(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes()->whereHas('transaction', function ($q) {
            $q->whereIn('type', Transaction::TYPE_BALANCE)
                ->whereState('status', Approved::label())->withoutGlobalScopes();
        });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsPr(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_PROFORMA)
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsCe(int $idTransaction = null): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) use ($idTransaction) {
                $q->where('type', Transaction::TYPE_CERTIFICATION)
                    ->when($idTransaction, function ($query) use ($idTransaction) {
                        $query->where('id', $idTransaction);
                    })
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsCeDraft(int $idTransaction = null): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) use ($idTransaction) {
                $q->where('type', Transaction::TYPE_CERTIFICATION)
                    ->when($idTransaction, function ($query) use ($idTransaction) {
                        $query->where('id', $idTransaction);
                    })
                    ->whereState('status', Draft::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsPrDraft(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_PROFORMA)
                    ->whereState('status', Draft::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsRe(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_REFORM)
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsReDraft(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_REFORM)
                    ->whereState('status', Draft::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsAs(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_ACCRUED)
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsAsDraft(): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')->withoutGlobalScopes()
            ->whereHas('transaction', function ($q) {
                $q->where('type', Transaction::TYPE_ACCRUED)
                    ->whereState('status', Draft::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsCm(int $idTransaction = null): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()->whereHas('transaction', function ($q) use ($idTransaction) {
                $q->where('type', Transaction::TYPE_COMMITMENT)
                    ->when($idTransaction, function ($query) use ($idTransaction) {
                        $query->where('id', $idTransaction);
                    })
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }

    /**
     * @return Builder|HasMany
     */
    public function transactionsCmDraft(int $idTransaction = null): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()->whereHas('transaction', function ($q) use ($idTransaction) {
                $q->where('type', Transaction::TYPE_COMMITMENT)
                    ->when($idTransaction, function ($query) use ($idTransaction) {
                        $query->where('id', $idTransaction);
                    })
                    ->whereState('status', Draft::class)->withoutGlobalScopes();
            });
    }


    /**
     * @return Builder|HasMany
     */
    public function transactionsCmCertification(int $certificationId = null): Builder|HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'account_id')
            ->withoutGlobalScopes()->whereHas('transaction', function ($q) use ($certificationId) {
                $q->where('parent_id', $certificationId)->where('type', Transaction::TYPE_COMMITMENT)
                    ->whereState('status', Approved::class)->withoutGlobalScopes();
            });
    }


    /**
     * @return Money
     */
    public function getBalancePrAttribute(): Money
    {
        $query = $this->transactionsPr();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalancePrDraftAttribute(): Money
    {
        $query = $this->transactionsPrDraft();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }


    /**
     * @return Money
     */
    public function getBalanceCmAttribute(int $transactionId = null): Money
    {
        $query = $this->transactionsCm($transactionId);

        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }

        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceCmDraftAttribute(int $transactionId = null): Money
    {
        $query = $this->transactionsCmDraft($transactionId);

        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }

        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceReAttribute(): Money
    {
        $query = $this->transactionsRe();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceReDraftAttribute(): Money
    {
        $query = $this->transactionsReDraft();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceAsAttribute(): Money
    {
        $query = $this->transactionsAs();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceAsDraftAttribute(): Money
    {
        $query = $this->transactionsAsDraft();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceCeApprovedAttribute(int $transactionId = null): Money
    {
        $query = $this->transactionsCe($transactionId);
        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceCeDraftAttribute(int $transactionId = null): Money
    {
        $query = $this->transactionsCeDraft($transactionId);
        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceAttribute(): Money
    {
        /*
         * Valor codificado - suma(valor por comprometer de lo certificado - sum(compromisos asociados a un certificado + los compromisos registrados sin una certificacion)
         * */
        $encodedValue = $this->balancePr->getAmount() + $this->balanceRe->getAmount();
        $certifiedValue = $this->balanceCeApproved->getAmount();
        $accruedValue = $this->balanceAs->getAmount();//valores devengados no asociados a un compromiso
        $balance = $encodedValue - ($certifiedValue + $accruedValue);
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceDraftAttribute(): Money
    {
        /*
         * Valor codificado - suma(valor por comprometer de lo certificado - sum(compromisos asociados a un certificado + los compromisos registrados sin una certificacion)
         * */
        $encodedValue = $this->balancePrDraft->getAmount() + $this->balanceReDraft->getAmount();
        $certifiedValue = $this->balanceCeDraft->getAmount();
        $accruedValue = $this->balanceAsDraft->getAmount();//valores devengados no asociados a un compromiso
        $balance = $encodedValue - ($certifiedValue + $accruedValue);
        return money($balance);
    }

    /**
     * @return Money
     */
    public function getBalanceEncoded(): Money
    {
        return $this->balancePr->getAmount() + $this->balanceRe->getAmount();
    }

    /**
     * @return Money
     */
    public function getBalanceEncodedApproved(): Money
    {
        return money($this->balancePr->getAmount() + $this->balanceRe->getAmount());
    }

    /**
     * @return Money
     */
    public function getBalanceEncodedDraft(): Money
    {
        return money($this->balancePrDraft->getAmount() + $this->balanceReDraft->getAmount());
    }


    /**
     * @param $state
     * @return Money
     */
    public function balanceDraft($state): Money
    {
        if ($state instanceof Approved) {
            return $this->getBalanceAttribute();
        } else {
            $query = $this->transactionsDetails();
            if ($query->count() > 0) {
                if ($this->type == self::TYPE_INCOME) {
                    $balance = $query->sum('debit') - $query->sum('credit');
                } else {
                    $balance = $query->sum('credit') - $query->sum('debit');
                }
            } else {
                $balance = 0;
            }
            return money($balance);
        }
    }

    /**
     * @return Money
     */
    public function balanceInitial(): Money
    {
        $query = $this->transactionsPr();
        if ($query->count() > 0) {
            if ($this->type == self::TYPE_INCOME) {
                $balance = $query->sum('debit') - $query->sum('credit');
            } else {
                $balance = $query->sum('credit') - $query->sum('debit');
            }
        } else {
            $balance = 0;
        }
        return money($balance);
    }


    /**
     * @param $transactionId
     * @return Money
     */
    public function getCertifiedValues($transactionId): Money
    {
        $query = $this->transactionsCe($transactionId);
        $queryCommitments = $this->transactionsCmCertification($transactionId);

        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }

        if ($queryCommitments->count() > 0) {
            $balanceCm = $queryCommitments->sum('debit');
        } else {
            $balanceCm = 0;
        }

        return money($balance - $balanceCm);
    }


    /**
     * @return Money
     */
    public function getBalanceCmApprovedAttribute(int $transactionId = null): Money
    {
        $query = $this->transactionsCe($transactionId);
        if ($query->count() > 0) {
            $balance = $query->sum('debit');
        } else {
            $balance = 0;
        }
        return money($balance);
    }
}
