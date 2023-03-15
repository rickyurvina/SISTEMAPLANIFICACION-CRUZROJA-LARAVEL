<?php

namespace App\Models\Common;

use App\Abstracts\Model;
use App\Models\Projects\ProjectAcquisitions;

class CatalogPurchase extends Model
{
    protected $table = 'catalog_purchases';

    protected bool $tenantable = false;

    protected $fillable = ['code', 'name', 'description', 'unit_price'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = strtoupper($model->code);
            $model->name = strtoupper($model->name);
            $model->description = strtoupper($model->description);
        });
        static::updating(function ($model){
            $model->code = strtoupper($model->code);
            $model->name = strtoupper($model->name);
            $model->description = strtoupper($model->description);
        });
    }

    public function acquisitions()
    {
        return $this->hasMany(ProjectAcquisitions::class, 'product_id');
    }
}
