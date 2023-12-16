<?php

namespace App\Http\Enums;

use App\Models\User;

class RoleEnum
{
	public static function all(): array
    {
        return [
            [
                "id" => User::ADMIN_APP,
                "name" => "Admin App"
            ],
            [
                "id" => User::OPERATOR,
                "name" => "Operator"
            ],
            [
                "id" => User::MEMBER,
                "name" => "Member Aplikasi"
            ],
        ];
    }
}
