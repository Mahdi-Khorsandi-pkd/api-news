<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ۱. ساخت کاربر
        $superAdmin = User::firstOrCreate(
            ['username' => 'naemiorg'], // با این فیلد چک می‌کند که کاربر تکراری ساخته نشود
            [
                'first_name' => 'Ali',
                'last_name' => 'Naemi',
                'email' => 'naemiorg@example.com',
                'password' => Hash::make('11111111'), // هش کردن پسورد
            ]
        );

        // ۲. اختصاص دادن نقش Super Admin به کاربر
        $superAdmin->assignRole('Admin');
    }
}
