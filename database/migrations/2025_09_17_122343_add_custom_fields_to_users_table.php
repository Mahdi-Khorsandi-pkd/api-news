<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف ستون name پیش‌فرض لاراول
            $table->dropColumn('name');

            // اضافه کردن ستون‌های جدید
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('username')->unique()->after('last_name');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // برگرداندن تغییرات در صورت rollback
            $table->string('name')->after('id');
            $table->dropColumn(['first_name', 'last_name', 'username', 'status']);
        });
    }
};
