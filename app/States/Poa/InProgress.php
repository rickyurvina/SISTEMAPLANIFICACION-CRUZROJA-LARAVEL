<?php

namespace App\States\Poa;

use App\Models\Poa\Poa;

class InProgress extends PoaState
{

    public static $name = 'EN PROCESO';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'EN PROCESO';
    }

    public function to(): ?PoaState
    {
        return new Reviewed(new Poa);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}