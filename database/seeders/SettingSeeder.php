<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // گروه اطلاعات سایت
        Setting::firstOrCreate(['group' => 'site_info', 'key' => 'title'], ['value' => 'صنعت کار | مجله اقتصادی صنعت کار']);
        Setting::firstOrCreate(['group' => 'site_info', 'key' => 'info_title'], ['value' => 'درباره صنعت کار']);
        Setting::firstOrCreate(['group' => 'site_info', 'key' => 'info_description'], ['value' => 'جامع ترین سایت تخصصی حوزه صنعت و خدمات -سعی بر آن بوده که مرجعی برای اطلاعات صنعت داخل ایران باشیم و بتوانیم به صورت تخصصی در این حوزه محتوا تولید نماییم. همواره پذیرای انتقادات و پیشنهادات شما خواهیم بود.']);
    }
}
