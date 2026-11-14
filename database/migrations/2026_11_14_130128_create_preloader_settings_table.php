<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('preloader_settings', function (Blueprint $table) {
        $table->id();

        // Content
        $table->string('name')->default('VIJAY Kumar');
        $table->string('designation')->default('FULL STACK DEVELOPER');
        $table->string('location')->default('DELHI, INDIA');

        // General
        $table->boolean('is_enabled')->default(true);
        $table->unsignedInteger('duration')->default(1000);

        // Colors
        $table->string('background_color')->default('#080D18');
        $table->string('text_color')->default('#FFFFFF');
        $table->string('progress_color')->default('#22D3EE');
        $table->string('percentage_color')->default('#22D3EE');

        // Logo
        $table->string('logo')->nullable();
        $table->boolean('show_logo')->default(false);
        $table->unsignedInteger('logo_size')->default(60);

        // Animation
        $table->string('animation_style')->default('progress');
        $table->unsignedInteger('animation_speed')->default(1000);

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('preloader_settings');
}
};
