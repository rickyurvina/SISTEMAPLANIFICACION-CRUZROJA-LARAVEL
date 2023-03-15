<?php

namespace App\States\Poa\Piat;

use App\Models\Poa\Piat\PoaActivityPiat;

class Pending extends PiatState
{
    public static $name = 'PENDIENTE';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'PENDIENTE';
    }

    public function to(): ?PiatState
    {
        return new ApprovedPiat(new PoaActivityPiat);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}