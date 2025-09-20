<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\SocialPlatformSeeder as SeedersSocialPlatformSeeder;
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
            RoleSeeder::class,         //  نقش‌ها
            SuperAdminSeeder::class,   //  ادمین
            WriterUserSeeder::class,   // نویسنده
            SectionSeeder::class, // بخش ها
            MenuSeeder::class, // نوع منو
            SocialPlatformSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
