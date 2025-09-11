<?php

namespace App\Enum;

enum RolesEnum:string
{
    case Client = "client";
    case Admin = "admin";
    case Association = "association";
    public static function labels(): array
    {
        return [
            self::Admin->value => 'Admin',
            self::Association->value => 'Association',
            self::Client->value => 'Client',
        ];
    }
    public function label()
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Association => 'Association',
            self::Client => 'Client',
        };
    }
}
