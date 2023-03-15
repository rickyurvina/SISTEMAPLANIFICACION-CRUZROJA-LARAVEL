<?php

namespace App\States\Transaction;

class Liquidated extends TransactionState
{
    public static $name = 'LIQUIDADA';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'LIQUIDADA';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}