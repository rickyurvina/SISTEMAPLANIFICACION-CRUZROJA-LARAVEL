<?php

namespace App\Models\Poa;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoaActivityTemplate extends Model
{
    use HasFactory;

    protected $table = 'poa_activity_templates';

    protected $fillable = ['name', 'code', 'cost', 'impact', 'complexity', 'created_at', 'updated_at', 'deleted_at'];

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

    public function scopeIsDeleted($query){
        return $query->where('deleted_at',null);
    }

}
