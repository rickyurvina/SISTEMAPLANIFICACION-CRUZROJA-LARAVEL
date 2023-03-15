<?php

namespace App\States\Poa\Piat;

use App\Models\Poa\Piat\PoaActivityPiat;
use App\States\Poa\Piat\ApprovedPiat;
use App\States\Poa\Piat\PiatState;

class Confirmed extends PiatState
{
    public static $name = 'CONFIRMADO';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'CONFIRMADO';
    }

    public function to(): ?PiatState
    {
        return new Pending(new PoaActivityPiat);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}