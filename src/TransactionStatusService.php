<?php

namespace Ampeco\OmnipayApcopay;

class TransactionStatusService
{
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_CAPTURED = 'CAPTURED';
    public const STATUS_VOIDED = 'VOIDED';
    public const STATUS_DECLINED = 'DECLINED';

    public static function getExpectedTransactionStatus(string $status): string
    {
        switch ($status) {
            case 'AUTH':
                return self::STATUS_APPROVED;
            case 'CAPT':
            case 'PURC':
                return self::STATUS_CAPTURED;
            case 'VOIDCR':
                return self::STATUS_VOIDED;
            default:
                return '';
        }
    }
}
