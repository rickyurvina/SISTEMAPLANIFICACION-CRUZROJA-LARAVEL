<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Canceled extends ProjectState
{
    public static $name = 'Cancelado';

    public static function color(): string
    {
        return 'bg-danger-700';
    }

    public static function label(): string
    {
        return 'Cancelado';
    }

    public function to(string $type=null): ?ProjectState
    {
        if ($type == Project::STATE_GENERAL_EXECUTION) {
            return new Execution(new Project());
        } elseif ($type == Project::STATE_PENDING) {
            return new Pending(new Project());
        } elseif ($type == Project::STATE_GENERAL_COMPLETED) {
            return new Completed(new Project());
        } elseif ($type == Project::STATE_GENERAL_DISCONTINUED) {
            return new Discontinued(new Project());
        } else {
            return new Extension(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}