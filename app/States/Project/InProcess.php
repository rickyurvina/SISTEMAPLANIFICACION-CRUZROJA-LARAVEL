<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class InProcess extends ProjectState
{
    public static $name = 'En proceso';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'En proceso';
    }

    public function to(string $type=null): ?ProjectState
    {
        return new InReview(new Project());
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}