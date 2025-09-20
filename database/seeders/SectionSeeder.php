<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Section::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Section::firstOrCreate(
            ['type' => 'header_slider'],
            ['name' => 'محتوای اسلایدر صفحه اصلی']
        );

        Section::firstOrCreate(
            ['type' => 'left_content'],
            ['name' => 'محتوای سمت چپ']
        );

        Section::firstOrCreate(
            ['type' => 'footer_content'],
            ['name' => 'محتوای فوتر اول']
        );
        Section::firstOrCreate(
            ['type' => 'footer_slider'],
            ['name' => 'محتوای اسلایدر فوتر']
        );
    }
}
