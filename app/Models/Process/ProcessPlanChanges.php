<?php

namespace App\Models\Process;

use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class ProcessPlanChanges extends Model
{
    use Mediable;

    protected bool $tenantable = false;

    protected $fillable = [
        'code',
        'date',
        'user_id',
        'process_id',
        'description',
        'objective',
        'consequence',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public array $sortable =
        [
            'code',
            'date',
            'user_id',
            'process_id',
            'description',
            'objective',
            'consequence',
        ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = mb_strtoupper($model->description);
            $model->objective = mb_strtoupper($model->objective);
            $model->consequence = mb_strtoupper($model->consequence);
         });
        static::updating(function ($model) {
            $model->description = mb_strtoupper($model->description);
            $model->objective = mb_strtoupper($model->objective);
            $model->consequence = mb_strtoupper($model->consequence);
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

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
