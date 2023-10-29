<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminApp = User::factory()->create([
            "email" => "admin.app@mailinator.com"
        ]);
        $adminApp->assignRole(Role::findById(User::ADMIN_APP, 'web'));

        $operator = User::factory()->create([
            "email" => "operator@mailinator.com"
        ]);
        $operator->assignRole(Role::findById(User::OPERATOR, 'web'));
    }
}
