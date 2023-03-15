<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Implementation extends ProjectPhase
{
    public static $name = 'Implementación';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'Implementación';
    }

    public function to(string $type = null): ?ProjectPhase
    {
        if ($type == Project::PHASE_START_UP) {
            return new StartUp(new Project());
        } else {
            return new Closing(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}