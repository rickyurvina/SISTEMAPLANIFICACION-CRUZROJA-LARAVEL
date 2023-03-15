<?php

namespace App\States\Process;

use App\Models\Process\Process;
use App\States\Process\ProcessPhase;

class Check extends ProcessPhase
{
    public static $name = 'Verificar';

    public static function color(): string
    {
        return 'bg-secondary-700';
    }

    public static function label(): string
    {
        return 'Verificar';
    }

    public function to(string $type = null): ?ProcessPhase
    {
        if ($type == Process::PHASE_PLAN) {
            return new Plan(new Process());
        } else if ($type == Process::PHASE_ACT) {
            return new Act(new Process());
        } else if ($type == Process::PHASE_DO_PROCESS) {
            return new DoProcess(new Process());
        } else {
            return new Plan(new Process());
        }
    }


    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}