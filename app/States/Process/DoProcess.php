<?php

namespace App\States\Process;

use App\Models\Process\Process;
use App\States\Process\ProcessPhase;


class DoProcess extends ProcessPhase
{
    public static $name = 'Hacer';

    public static function color(): string
    {
        return 'bg-secondary-700';
    }

    public static function label(): string
    {
        return 'Hacer';
    }

    public function to(string $type = null): ?ProcessPhase
    {
        if ($type == Process::PHASE_PLAN) {
            return new Plan(new Process());
        } else if ($type == Process::PHASE_ACT) {
            return new Act(new Process());
        } else if ($type == Process::PHASE_CHECK) {
            return new Check(new Process());
        }else{
            return new Check(new Process());
        }
    }


    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}