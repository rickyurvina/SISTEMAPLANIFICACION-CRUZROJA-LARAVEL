<?php

namespace App\States\Poa;

use App\Models\Poa\Poa;

class Reviewed extends PoaState
{

    public static $name = 'REVISADO';

    public static function color(): string
    {
        return 'bg-info-700';
    }

    public static function label(): string
    {
        return 'REVISADO';
    }

    public function to(): ?PoaState
    {
        return new Approved(new Poa);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}