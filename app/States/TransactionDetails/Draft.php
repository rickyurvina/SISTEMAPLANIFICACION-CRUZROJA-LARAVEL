<?php

namespace App\States\TransactionDetails;

use App\Models\Budget\Transaction;

class Draft extends TransactionDetailsState
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

    public function to(): ?TransactionDetailsState
    {
        return new Approved(new Transaction);
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}