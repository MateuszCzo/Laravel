<?php

namespace App\Enums;

class PaymentStatus
{
    public const IN_PROGRESS = 'in_progress';
    public const SUCCESS = 'success';
    public const FAIL = 'fail';

    public const TYPES = [
        self::IN_PROGRESS,
        self::SUCCESS,
        self::FAIL
    ];
}