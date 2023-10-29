<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [Role::ADMIN_APP, Role::OPERATOR, Role::KORWIL, Role::MEMBER_APP, Role::MEMBER];

        foreach ($roles as $role) {
            Role::create([
                "name" => $role,
            ]);
        }
    }
}
