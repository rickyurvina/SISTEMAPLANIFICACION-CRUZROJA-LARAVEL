<?php

namespace App\States\Transaction;

use App\Models\Budget\Transaction;

class Draft extends TransactionState
{
    public static $name = 'BORRADOR';

    public static function color(): string
    {
        return 'bg-warning-700';
    }

    public static function label(): string
    {
        return 'BORRADOR';
    }

    public function to(): ?TransactionState
    {
        return new Approved(new Transaction);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}