<?php

namespace App\Models\Budget;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use App\States\TransactionDetails\Draft;
use App\States\TransactionDetails\TransactionDetailsState;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class TransactionDetail extends Model
{
    use Mediable;
    protected $table = 'bdg_transaction_details';

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes()
    {
    }

    protected $casts = [
        'status' => TransactionDetailsState::class
    ];

    protected $fillable = [
        'number',
        'debit',
        'credit',
        'description',
        'transaction_id',
        'account_id',
        'company_id',
        'approved_by',
        'status',
    ];


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = strtoupper($model->description);
            $model->status = Draft::label();
        });
        static::updating(function ($model) {
            $model->description = strtoupper($model->description);
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @param Money|float $value
     */
    protected function getDebitAttribute($value): Money
    {
        return money($value ?? 0);
    }

    /**
     * @param Money|float $value
     */
    protected function setDebitAttribute($value): void
    {
        $value = is_a($value, Money::class) ? $value : (is_null($value) ? $value : money($value));
        $this->attributes['debit'] = $value ? (int)$value->getAmount() : null;
    }

    /**
     * @param Money|float $value
     */
    protected function getCreditAttribute($value): Money
    {
        return money($value ?? 0);
    }

    /**
     * @param Money|float $value
     */
    protected function setCreditAttribute($value): void
    {
        $value = is_a($value, Money::class) ? $value : (is_null($value) ? $value : money($value));
        $this->attributes['credit'] = $value ? (int)$value->getAmount() : null;
    }

    public function approvedBy()
    {
        $this->belongsTo(User::class, 'approved_by');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }
}
