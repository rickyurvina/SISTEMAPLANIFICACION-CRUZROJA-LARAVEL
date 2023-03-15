<?php

namespace App\States\Transaction;

class Rejected extends TransactionState
{
    public static $name = 'RECHAZADA';

    public static function color(): string
    {
        return 'bg-danger-700';
    }

    public static function label(): string
    {
        return 'RECHAZADA';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}