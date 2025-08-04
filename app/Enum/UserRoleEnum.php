<?php

namespace App\Enum;

enum UserRoleEnum : string
{
    case Admin = 'admin';
    case User = 'user';
    public static function toArray(): array
    {
        return [
            self::Admin->value ,
            self::User->value ,
        ];
    }
}
