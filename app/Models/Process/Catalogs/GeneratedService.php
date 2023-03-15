<?php

namespace App\Models\Process\Catalogs;

use App\Models\Process\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedService extends Model
{
    use HasFactory;

    protected $table = 'generated_services';

    protected $fillable = ['code', 'name', 'description'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->code = mb_strtoupper($model->code);
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function activityGeneratedService()
    {
        return $this->morphMany(Activity::class, 'generated_service_id');

    }


}
