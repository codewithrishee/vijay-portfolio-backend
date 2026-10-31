<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('hero_sections', function (Blueprint $table) {
        $table->id();
        $table->string('name')->default('Vijay Kumar');
        $table->string('eyebrow')->default('AVAILABLE FOR OPPORTUNITIES');
        $table->string('role_prefix')->default('Full Stack');
        $table->string('role_suffix')->default('Developer');
        $table->string('technologies')->default('PHP · Laravel · React');
        $table->string('heading_line_1')->default('I build production-ready');
        $table->string('heading_line_2')->default('interfaces for the modern web.');
        $table->json('roles')->nullable();
        $table->text('description')->nullable();
        $table->string('primary_button_text')->default('Explore My Work');
        $table->string('primary_button_link')->default='#projects';
        $table->string('secondary_button_text')->default('Get in touch');
        $table->string('secondary_button_link')->default('#contact');
        $table->string('github_url')->nullable();
        $table->string('linkedin_url')->nullable();
        $table->string('experience_value')->default('06+');
        $table->string('experience_label')->default('MONTHS EXPERIENCE');
        $table->string('technology_count')->default('05+');
        $table->string('technology_label')->default('TECHNOLOGIES');
        $table->string('project_count')->default('03+');
        $table->string('project_label')->default('PROJECTS BUILT');
        $table->string('availability_text')->default('Open');
        $table->string('availability_label')->default('TO OPPORTUNITIES');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('hero_sections');
}
};
