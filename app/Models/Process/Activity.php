<?php

namespace App\Models\Process;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use App\Models\Process\Catalogs\GeneratedService;
use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class Activity extends Model
{
    use Mediable;

    protected $table = 'process_activities';

    protected $fillable =
        [
            'code',
            'name',
            'expected_result',
            'generated_service_id',
            'specifications',
            'cares',
            'procedures',
            'equipment',
            'supplies',
            'process_id',
            'company_id'
        ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public array $sortable = ['code', 'name', 'expected_result', 'specifications', 'cares', 'procedures', 'equipment', 'supplies', 'process_id', 'company_id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->expected_result = mb_strtoupper($model->expected_result);
            $model->specifications = mb_strtoupper($model->specifications);
            $model->cares = mb_strtoupper($model->cares);
            $model->procedures = mb_strtoupper($model->procedures);
            $model->equipment = mb_strtoupper($model->equipment);
            $model->supplies = mb_strtoupper($model->supplies);
        });
        static::updating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->expected_result = mb_strtoupper($model->expected_result);
            $model->specifications = mb_strtoupper($model->specifications);
            $model->cares = mb_strtoupper($model->cares);
            $model->procedures = mb_strtoupper($model->procedures);
            $model->equipment = mb_strtoupper($model->equipment);
            $model->supplies = mb_strtoupper($model->supplies);
        });
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    /**
     * Activity responsible
     *
     * @return BelongsTo
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function risks()
    {
        return $this->morphMany(Risk::class, 'riskable');
    }

    public function generatedService()
    {
        return $this->belongsTo(GeneratedService::class,'generated_service_id');
    }
}
