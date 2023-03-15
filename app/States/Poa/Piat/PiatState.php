<?php

namespace App\States\Poa\Piat;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PiatState extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?PiatState
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, ApprovedPiat::class)
            ->allowTransition(ApprovedPiat::class, Confirmed::class)
            ->allowTransition(Confirmed::class, Pending::class);
    }
}
