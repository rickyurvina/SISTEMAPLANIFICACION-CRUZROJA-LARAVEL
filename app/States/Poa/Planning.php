<?php

namespace App\States\Poa;

use App\Models\Poa\Poa;

class Planning extends PoaPhase
{

    public static $name = 'PLANIFICACIÓN';

    public static function color(): string
    {
        return 'bg-fusion-700';
    }

    public static function label(): string
    {
        return 'PLANIFICACIÓN';
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