<?php

namespace App\Models\Budget\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetClassifier extends Model
{
    use HasFactory;
    const LEVEL_2 = 2;
    const LEVEL_4 = 4;

    public $timestamps = true;
    protected bool $tenantable = false;
    protected $table = 'bdg_classifiers';

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'code',
        'full_code',
        'title',
        'description',
        'level'
    ];

    /**
     * Obtener clasificador presupuestario padre.
     *
     * @return BelongsTo
     */

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = strtoupper($model->code);
            $model->title = strtoupper($model->title);
            $model->description = strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->code = strtoupper($model->code);
            $model->title = strtoupper($model->title);
            $model->description = strtoupper($model->description);
        });
    }

    public function parent()
    {
        return $this->belongsTo(BudgetClassifier::class, 'parent_id');
    }

    /**
     * Obtener hijos de clasificador presupuestario.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(BudgetClassifier::class, 'parent_id');
    }
}
