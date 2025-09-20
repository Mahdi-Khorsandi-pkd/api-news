<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::firstOrCreate(
            ['location' => 'header'],
            ['name' => 'منوی اصلی']
        );

        Menu::firstOrCreate(
            ['location' => 'footer'],
            ['name' => 'منوی فوتر']
        );
    }
}
