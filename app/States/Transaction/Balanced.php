<?php

namespace App\States\Transaction;

class Balanced extends TransactionState
{
    public static $name = 'CUADRADO';

    public static function color(): string
    {
        return 'bg-primary-700';
    }

    public static function label(): string
    {
        return 'CUADRADO';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}