<?php

namespace App\Models\Common;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class CatalogDetail extends Model
{
    use Sortable;

    protected $table = 'catalog_details';

    protected bool $tenantable = false;

    protected static $recordEvents = [];

    protected $fillable = ['id', 'catalog_id', 'code', 'description', 'properties', 'enabled'];

    public $casts = ['properties' => 'array'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }
}