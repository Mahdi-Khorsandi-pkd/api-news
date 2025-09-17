<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::firstOrCreate(
            ['type' => 'left_content'],
            ['name' => 'محتوای سمت چپ']
        );

        Section::firstOrCreate(
            ['type' => 'footer_content_1'],
            ['name' => 'محتوای فوتر اول']
        );
        Section::firstOrCreate(
            ['type' => 'footer_content_2'],
            ['name' => 'محتوای فوتر دوم']
        );
    }
}
