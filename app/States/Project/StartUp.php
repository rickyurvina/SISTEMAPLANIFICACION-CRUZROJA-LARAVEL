<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class StartUp extends ProjectPhase
{
    public static $name = 'Inicio';

    public static function color(): string
    {
        return 'bg-primary-700';
    }

    public static function label(): string
    {
        return 'Inicio';
    }

    public function to(string $type=null): ?ProjectPhase
    {
        return new Planning(new Project());
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}