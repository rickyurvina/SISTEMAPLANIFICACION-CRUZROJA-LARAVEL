<?php

namespace App\Models\Vendor\Spatie;

use App\Abstracts\Model;
use App\Models\Admin\Company;
use App\Models\Auth\User;
use App\Scopes\Company as CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends \Spatie\Activitylog\Models\Activity
{

    protected bool $tenantable = true;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model) {
            $model->company_id = session('company_id');
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
