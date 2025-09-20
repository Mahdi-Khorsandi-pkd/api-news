<?php

namespace Database\Seeders;

use App\Models\SocialPlatform;
use Illuminate\Database\Seeder;

class SocialPlatformSeeder extends Seeder
{
    public function run(): void
    {
        SocialPlatform::firstOrCreate(['key' => 'instagram'], ['name' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'color' => '#E4405F']);
        SocialPlatform::firstOrCreate(['key' => 'x'], ['name' => 'X (Twitter)', 'icon' => 'fa-brands fa-x-twitter', 'color' => '#000000']);
        SocialPlatform::firstOrCreate(['key' => 'telegram'], ['name' => 'Telegram', 'icon' => 'fa-brands fa-telegram', 'color' => '#26A5E4']);
    }
}
