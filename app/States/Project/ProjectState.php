<?php

namespace App\States\Project;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProjectState extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?ProjectState
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(InProcess::class)
            ->allowTransition([Financed::class, Formulated::class, InReview::class], InProcess::class)
            ->allowTransition([InProcess::class], InReview::class)
            ->allowTransition([InReview::class], Formulated::class)
            ->allowTransition([Formulated::class], Financed::class)
            ->allowTransition([Financed::class, Closed::class], Pending::class)
            ->allowTransition(Pending::class, Closed::class)
            ->allowTransition(Formulated::class, Pending::class, FormulatedToFinanced::class)
            ->allowTransition(Pending::class, Completed::class, PendingToCompleted::class)
            ->allowTransition([InReview::class, Financed::class], Formulated::class)
            ->allowTransition([Execution::class, Extension::class, Canceled::class, Discontinued::class], Completed::class)
            ->allowTransition([Execution::class, Discontinued::class, Canceled::class, Completed::class], Extension::class)
            ->allowTransition([Execution::class, Discontinued::class, Canceled::class, Completed::class], Discontinued::class)
            ->allowTransition([Extension::class, Discontinued::class, Canceled::class, Completed::class], Execution::class)
            ->allowTransition([Extension::class, Discontinued::class, Execution::class, Completed::class], Canceled::class);
    }
}