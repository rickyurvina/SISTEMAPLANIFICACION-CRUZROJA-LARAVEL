<?php

namespace App\States\Process;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProcessPhase extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?ProcessPhase
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Plan::class)
            ->allowTransition([Check::class ,Act::class, DoProcess::class],  Plan::class)
            ->allowTransition([Plan::class ,Check::class, DoProcess::class],  Act::class)
            ->allowTransition([Plan::class ,Act::class, Check::class],  DoProcess::class)
            ->allowTransition([Act::class ,DoProcess::class, Plan::class],  Check::class);

    }
}