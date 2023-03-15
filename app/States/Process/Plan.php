<?php

namespace App\States\Process;

use App\Models\Process\Process;

class Plan extends ProcessPhase
{
    public static $name = 'Planear';

    public static function color(): string
    {
        return 'bg-primary-700';
    }

    public static function label(): string
    {
        return 'Planear';
    }

    public function to(string $type = null): ?ProcessPhase
    {
        if ($type == Process::PHASE_DO_PROCESS) {
            return new DoProcess(new Process());
        } else if ($type == Process::PHASE_ACT) {
            return new Act(new Process());
        } else if ($type == Process::PHASE_CHECK) {
            return new Check(new Process());
        }else{
            return new Act(new Process());
        }
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}