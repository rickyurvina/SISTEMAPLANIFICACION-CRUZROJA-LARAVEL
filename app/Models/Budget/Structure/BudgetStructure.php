<?php

namespace App\Models\Budget\Structure;

use App\Abstracts\Model;
use App\Models\Budget\Transaction;

class BudgetStructure extends Model
{

    const SOURCE_TYPE_MODEL = 'model';
    const INCOMES = 'INGRESOS';
    const EXPENSES = 'GASTOS';

    public $timestamps = true;

    protected bool $tenantable = false;

    protected $table = 'bdg_structures';

    /**
     * Disable soft deletes for this model
     */
    public static function bootSoftDeletes() {}

    protected $fillable =
        [
            'year',
            'type',
            'level',
            'name',
            'length',
            'model_type',
            'model_field',
            'model_field',
            'model_field_name',
            'deleted_at',
            'created_at',
            'updated_at',
            'bdg_transaction_id',
            'settings',
        ];

    protected $casts = ['settings' => 'array'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
        });
        static::updating(function ($model){
            $model->name = strtoupper($model->name);
        });
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

}
