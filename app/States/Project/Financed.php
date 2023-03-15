<?php

namespace App\States\Project;

use App\Models\Projects\Project;

class Financed extends ProjectState
{
    public static $name = 'Financiado';

    public static function color(): string
    {
        return 'bg-dark-700';
    }

    public static function label(): string
    {
        return 'Financiado';
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