<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Planning extends ProjectPhase
{
    public static $name = 'Planificación';

    public static function color(): string
    {
        return 'bg-warning-300';
    }

    public static function label(): string
    {
        return 'Planificación';
    }

    public function to(string $type=null): ?ProjectPhase
    {
        if ($type == Project::PHASE_START_UP) {
            return new StartUp(new Project());
        } else{
            return new Implementation(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}