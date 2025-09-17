<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,         // اول نقش‌ها
            SuperAdminSeeder::class,   // سپس ادمین
            WriterUserSeeder::class,   // و در نهایت نویسنده
        ]);
    }
}
