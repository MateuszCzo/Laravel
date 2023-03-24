<?php

namespace App\Enums;

class UserRole
{
    public const ADMIN = 'admin';
    public const USER = 'user';

    public const TYPES =[
        self::ADMIN,
        self::USER
    ];
}