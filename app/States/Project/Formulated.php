<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Formulated extends ProjectState
{
    public static $name = 'Formulado';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'Formulado';
    }

    public function to(string $type=null): ?ProjectState
    {
        if ($type == Project::STATE_IN_PROCESS) {
            return new InProcess(new Project());
        } else{
            return new Pending(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}