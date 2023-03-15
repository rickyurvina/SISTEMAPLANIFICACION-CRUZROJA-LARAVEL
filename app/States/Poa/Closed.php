<?php

namespace App\States\Poa;

use App\Models\Poa\Poa;

class Closed extends PoaPhase
{
    public static $name = 'CERRADO';

    public static function color(): string
    {
        return 'bg-fusion-700';
    }

    public static function label(): string
    {
        return 'CERRADO';
    }

    public function to(): ?PoaPhase
    {
        return new Execution(new Poa);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}