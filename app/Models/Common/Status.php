<?php

namespace App\Models\Common;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends \Spatie\ModelStatus\Status
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = user()->id;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
