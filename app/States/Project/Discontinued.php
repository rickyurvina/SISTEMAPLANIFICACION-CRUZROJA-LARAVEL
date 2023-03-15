<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Discontinued extends ProjectState
{
    public static $name = 'Suspendido';

    public static function color(): string
    {
        return 'bg-light';
    }

    public static function label(): string
    {
        return 'Suspendido';
    }

    public function to(string $type=null): ?ProjectState
    {
        if ($type == Project::STATE_GENERAL_EXECUTION) {
            return new Execution(new Project());
        } elseif ($type == Project::STATE_PENDING) {
            return new Pending(new Project());
        } elseif ($type == Project::STATE_GENERAL_CANCELLED) {
            return new Canceled(new Project());
        } elseif ($type == Project::STATE_GENERAL_COMPLETED) {
            return new Completed(new Project());
        } else {
            return new Extension(new Project());
        }
    }


    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}