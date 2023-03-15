<?php

namespace App\States\Transaction;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TransactionState extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?TransactionState
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, Approved::class)
            ->allowTransition(Draft::class, Digited::class)
            ->allowTransition(Digited::class, Balanced::class)
            ->allowTransition(Balanced::class, Approved::class)
            ->allowTransition(Balanced::class, Digited::class)
            ->allowTransition(Digited::class, Approved::class);
    }
}