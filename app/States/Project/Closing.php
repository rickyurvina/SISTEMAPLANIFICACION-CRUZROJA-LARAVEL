<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Closing extends ProjectPhase
{
    public static $name = 'Cierre';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'Cierre';
    }

    public function to(string $type=null): ?ProjectPhase
    {
        return new StartUp(new Project());
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}