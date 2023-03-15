<?php

namespace App\States\TransactionDetails;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TransactionDetailsState extends State
{
    abstract public static function color(): string;

    abstract public static function label(): string;

    abstract public function isActive(string $state): string;

    public function to(): ?TransactionDetailsState
    {
        return null;
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, Approved::class);
    }

}