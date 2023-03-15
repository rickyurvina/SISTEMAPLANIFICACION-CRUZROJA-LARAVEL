<?php

namespace App\Models\Common;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogGeographicClassifier extends Model
{
    use HasFactory;

    const TYPE_CANTON = 'CANTON';
    const TYPE_PARISH = 'PARISH';
    const TYPE_PROVINCE = 'PROVINCE';

    const NO_PROVINCE = 1;
    const NO_CANTON = 2;
    const NO_PARISH = 3;
    const NO_LOCATION_CODE = '00';

    /**
     * @var bool
     */
    public $timestamps = true;

    protected bool $tenantable = false;

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'code',
        'full_code',
        'description',
        'type'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
    }

    /**
     * Obtener localización geográfica padre.
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(CatalogGeographicClassifier::class, 'parent_id');
    }

    /**
     * Obtener hijos de localización geográfica.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(CatalogGeographicClassifier::class, 'parent_id');
    }

    /**
     * Retorna los tipos de localizaciones
     *
     * @return array
     */
    public static function types()
    {
        return [
            'CANTON' => trans('budget.labels.' . 'CANTON'),
            'PARISH' => trans('budget.labels.' . 'PARISH'),
            'PROVINCE' => trans('budget.labels.' . 'PROVINCE')
        ];
    }

    public function getPath(string $path = null)
    {
        $parent = $this->parent()->first();

        if ($parent) {
            return $parent->getPath($parent->description . ' / ' . ($path ?? $this->description));
        } else {
            return $path ?? $this->description;
        }
    }
}
