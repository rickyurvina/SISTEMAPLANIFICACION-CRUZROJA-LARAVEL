<?php

namespace App\Models;

use App\Abstracts\Model;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $fillable = [
        'user_id',
        'parent_id',
        'comment',
        'commentable_id'
    ];


    public function commentable(): MorphTo
    {
        return $this->morphTo()->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function childs(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Comment::class, 'id');
    }
}
