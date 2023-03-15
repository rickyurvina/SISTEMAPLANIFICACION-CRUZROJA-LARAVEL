<?php

namespace App\States\Transaction;

class Digited extends TransactionState
{
    public static $name = 'DIGITADO';

    public static function color(): string
    {
        return 'bg-danger-700';
    }

    public static function label(): string
    {
        return 'DIGITADO';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}