<?php

namespace App\States\Transaction;

class Override extends TransactionState
{
    public static $name = 'ANULADA';

    public static function color(): string
    {
        return 'bg-gray-400';
    }

    public static function label(): string
    {
        return 'ANULADA';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}