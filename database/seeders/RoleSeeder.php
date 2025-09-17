<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ایجاد نقش Super Admin
        Role::create(['name' => 'Admin']);

        // ایجاد نقش Writer
        Role::create(['name' => 'Writer']);
    }


}
