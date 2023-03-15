<?php

namespace App\Models\Budget\Structure;

use App\Models\Admin\Department;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class BudgetGeneralExpensesStructure extends Model
{
    use HasFactory;

    protected $table = 'bdg_general_expenses_structures';

    protected $fillable =
        [
            'bdg_transaction_id',
            'parent_id',
            'code',
            'name',
            'responsible_unit',
            'executing_unit',
        ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
            $model->code = strtoupper($model->code);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
            $model->code = strtoupper($model->code);
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'bdg_transaction_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BudgetGeneralExpensesStructure::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(BudgetGeneralExpensesStructure::class, 'parent_id');
    }

    public function responsibleUnit(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'responsible_unit');
    }

    public function executingUnit(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'responsible_unit');
    }

    public function accounts(): MorphMany
    {
        return $this->morphMany(Account::class, 'accountable')->withoutGlobalScope(\App\Scopes\Company::class);
    }
}
