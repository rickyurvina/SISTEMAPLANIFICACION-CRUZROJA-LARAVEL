<?php

namespace App\Models\Poa;

use App\Abstracts\Model;
use App\Models\Measure\Measure;
use Illuminate\Database\Eloquent\Builder;

class PoaIndicatorConfig extends Model
{
    protected $table = 'poa_indicator_configs';

    protected bool $tenantable = false;

    protected $fillable = [
        'poa_id',
        'program_id',
        'selected',
        'reason',
        'measure_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->reason = strtoupper($model->reason);
        });
        static::updating(function ($model){
            $model->reason = strtoupper($model->reason);
        });
    }

    public function measure()
    {
        return $this->belongsTo(Measure::class,'measure_id')->withoutGlobalScopes();
    }

    public function program()
    {
        return $this->belongsTo(PoaProgram::class,'program_id');
    }

    public function poa()
    {
        return $this->belongsTo(Poa::class, 'poa_id');
    }

    public function scopeSelected(Builder $query)
    {
        return $query->where('selected', true);
    }
}
