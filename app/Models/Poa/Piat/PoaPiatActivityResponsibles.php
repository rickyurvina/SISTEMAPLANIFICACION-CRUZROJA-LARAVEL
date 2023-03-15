<?php

namespace App\Models\Poa\Piat;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoaPiatActivityResponsibles extends Model
{

    protected $fillable =
        [
            'user_id',
            'poa_activity_piat_id',
            'name',
            'email',
            'number_hours_worked',
            'description',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function poaActivityPiat(): BelongsTo
    {
        return $this->belongsTo(PoaActivityPiat::class, 'poa_activity_piat_id');
    }
}
