<?php

namespace App\States\TransactionDetails;


class Decline extends TransactionDetailsState
{
    public static $name = 'RECHAZADO';

    public static function color(): string
    {
        return 'bg-danger-700';
    }

    public static function label(): string
    {
        return 'RECHAZADO';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}