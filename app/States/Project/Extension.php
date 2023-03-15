<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Extension extends ProjectState
{
    public static $name = 'Extensión';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'Extensión';
    }

    public function to(string $type=null): ?ProjectState
    {
        if ($type == Project::STATE_GENERAL_EXECUTION) {
            return new Execution(new Project());
        } elseif ($type == Project::STATE_PENDING) {
            return new Pending(new Project());
        } elseif ($type == Project::STATE_GENERAL_CANCELLED) {
            return new Canceled(new Project());
        } elseif ($type == Project::STATE_GENERAL_DISCONTINUED) {
            return new Discontinued(new Project());
        } else {
            return new Completed(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}