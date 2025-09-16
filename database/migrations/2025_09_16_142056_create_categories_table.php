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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            // برای ساختار درختی (والد و فرزند)
            // این فیلد به آی‌دی یک دسته‌بندی دیگر در همین جدول اشاره دارد
            $table->foreignId('parent_id')
                  ->nullable() // می‌تواند والد نداشته باشد
                  ->constrained('categories') // کلید خارجی به جدول categories
                  ->onDelete('cascade'); // اگر والد حذف شد، فرزندان هم حذف شوند

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
