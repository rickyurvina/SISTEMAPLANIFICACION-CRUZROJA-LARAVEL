<?php

namespace App\States\Project;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;


abstract class ProjectPhase extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?ProjectPhase
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(StartUp::class)
            ->allowTransition([Planning::class, Implementation::class], StartUp::class, PlanningToStartUp::class)
            ->allowTransition([StartUp::class, Implementation::class], Planning::class, PhaseToPlanning::class)
            ->allowTransition(Planning::class, Implementation::class)
            ->allowTransition(Implementation::class, Closing::class, PlanningToClosing::class);
    }
}