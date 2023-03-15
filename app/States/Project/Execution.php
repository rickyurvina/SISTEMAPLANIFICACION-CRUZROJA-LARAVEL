<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Execution extends ProjectState
{
    public static $name = 'Ejecución';

    public static function color(): string
    {
        return 'bg-secondary-700';
    }

    public static function label(): string
    {
        return 'Ejecución';
    }
    public function to(string $type=null): ?ProjectState
    {
        if ($type == Project::STATE_GENERAL_COMPLETED) {
            return new Completed(new Project());
        } elseif ($type == Project::STATE_PENDING) {
            return new Pending(new Project());
        } elseif ($type == Project::STATE_GENERAL_CANCELLED) {
            return new Canceled(new Project());
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