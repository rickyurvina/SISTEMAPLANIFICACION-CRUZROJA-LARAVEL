<?php

namespace App\Models\Indicators\Threshold;


use App\Abstracts\Model;
use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Threshold extends Model
{
    use HasFactory;

    const ASCENDING = 'Ascending';
    const DESCENDING = 'Descending';
    const DANGER = 'Danger';
    const  WARNING = 'Warning';
    const SUCCESS = 'Success';
    const TOLERANCE = 'Tolerance';

    protected $casts = [
        'properties' => 'array'
    ];

    protected $fillable = ['name', 'properties'];

    protected bool $tenantable = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
    }
    /**
     * Get the indicator
     *
     * @return BelongsToMany
     */

    public function indicator()
    {
        return $this->belongsToMany(Indicator::class, 'indicators_id');
    }

}
