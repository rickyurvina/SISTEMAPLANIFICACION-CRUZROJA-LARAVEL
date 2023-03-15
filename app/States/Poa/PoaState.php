<?php

namespace App\States\Poa;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PoaState extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?PoaState
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(InProgress::class)
            ->allowTransition(InProgress::class, Reviewed::class)
            ->allowTransition(Reviewed::class, Approved::class)
            ->allowTransition(Approved::class, InProgress::class);
    }
}
