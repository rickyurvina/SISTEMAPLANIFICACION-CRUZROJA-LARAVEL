<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calendar extends Model
{
    use HasFactory;

    const FREQUENCY_YEARLY = 'yearly';
    const FREQUENCY_QUARTERLY = 'quarterly';
    const FREQUENCY_SEMESTER = 'semester';
    const FREQUENCY_MONTHLY = 'monthly';

    const CALENDARS = [
        self::FREQUENCY_YEARLY => self::FREQUENCY_YEARLY,
        self::FREQUENCY_QUARTERLY => self::FREQUENCY_QUARTERLY,
        self::FREQUENCY_SEMESTER => self::FREQUENCY_SEMESTER,
        self::FREQUENCY_MONTHLY => self::FREQUENCY_MONTHLY,
    ];

    const CALENDARS_CHILD = [
        self::FREQUENCY_YEARLY => ['monthly', 'quarterly', 'semester', 'yearly'],
        self::FREQUENCY_SEMESTER => ['semester', 'quarterly', 'monthly'],
        self::FREQUENCY_QUARTERLY => ['quarterly', 'monthly'],
        self::FREQUENCY_MONTHLY => ['monthly'],
    ];

    protected bool $tenantable = false;

    protected $table = 'msr_calendars';

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    public function periods(): HasMany
    {
        return $this->hasMany(Period::class, 'calendar_id')->orderBy('start_date', 'ASC');
    }
}
