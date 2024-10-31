<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'User', 'guard_name' => 'web']);
        Role::create(['name' => 'CareProvider', 'guard_name' => 'web']);
        Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);

    }
}
