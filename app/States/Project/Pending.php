<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Pending extends ProjectState
{
    public static $name = 'Pendiente';

    public static function color(): string
    {
        return 'bg-danger-400';
    }

    public static function label(): string
    {
        return 'Pendiente';
    }

    public function to(string $type = null): ?ProjectState
    {
        if ($type == Project::STATE_IN_PROCESS) {
            return new InProcess(new Project());
        } else if($type==Project::STATE_CLOSED){
            return new Closed(new Project());
        }
        else {
            return new Completed(new Project());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}