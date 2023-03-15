<?php

namespace App\States\Poa;

use App\Models\Poa\Poa;

class Approved extends PoaState
{
    public static $name = 'APROBADO';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'APROBADO';
    }

    public function to(): ?PoaState
    {
        return new InProgress(new Poa);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}