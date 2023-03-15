<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Closed extends ProjectState
{
    public static $name = 'Cerrado';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'Cerrado';
    }

    public function to(string $type=null): ?ProjectState
    {
        return new Pending(new Project());
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}