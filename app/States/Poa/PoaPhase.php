<?php

namespace App\States\Poa;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PoaPhase extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?PoaPhase
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Planning::class)
            ->allowTransition(Planning::class, Execution::class)
            ->allowTransition(Closed::class, Execution::class)
            ->allowTransition(Execution::class, Closed::class);
    }
}
