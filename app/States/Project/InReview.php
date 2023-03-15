<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class InReview extends ProjectState
{
    public static $name = 'En Revisión';

    public static function color(): string
    {
        return 'bg-info';
    }

    public static function label(): string
    {
        return 'En Revisión';
    }

    public function to(string $type=null): ?ProjectState
    {;
        if ($type == Project::STATE_IN_PROCESS) {
            return new InProcess(new Project());
        } else{
            return new Formulated(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}