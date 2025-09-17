<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WriterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ۱. ساخت کاربر نویسنده
        $writer = User::firstOrCreate(
            ['username' => 'writer'], // با این فیلد چک می‌کند که کاربر تکراری ساخته نشود
            [
                'first_name' => 'Test',
                'last_name' => 'Writer',
                'email' => 'writer@example.com',
                'password' => Hash::make('11111111'), // هش کردن پسورد
            ]
        );

        // ۲. اختصاص دادن نقش Writer به کاربر
        $writer->assignRole('Writer');
    }
}
