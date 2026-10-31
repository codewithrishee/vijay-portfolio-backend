<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('about_sections', function (Blueprint $table) {
        $table->id();

        // Profile
        $table->string('name')->default('Vijay Kumar');
        $table->string('location')->default('Delhi, India');
        $table->string('image')->nullable();
        $table->string('education')->default('BA — IGNOU');
        $table->string('education_description')->default('Undergraduate · Open University');
        $table->string('profile_technologies')->default('PHP · LARAVEL · REACT');

        // About content
        $table->string('section_number')->default('04');
        $table->string('heading');
        $table->text('paragraph_1');
        $table->text('paragraph_2');
        $table->text('paragraph_3')->nullable();

        // Information panel
        $table->string('looking_for')->nullable();
        $table->string('availability')->nullable();
        $table->string('technologies')->nullable();

        // Settings
        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('about_sections');
}
};
