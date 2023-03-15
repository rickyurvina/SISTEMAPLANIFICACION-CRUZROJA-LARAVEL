<?php

namespace App\States\TransactionDetails;


class Approved extends TransactionDetailsState
{
    public static $name = 'APROBADO';

    public static function color(): string
    {
        return 'bg-success-700';
    }

    public static function label(): string
    {
        return 'APROBADO';
    }

    public function isActive(string $state): string
    {
        return $this instanceof $state;
    }
}