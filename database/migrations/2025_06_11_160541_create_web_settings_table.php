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
        Schema::create('web_settings', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('moto')->nullable();
        $table->string('logo')->nullable();
        $table->string('favicon')->nullable();
        $table->string('address')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->json('opening_closing_days')->nullable();
        $table->string('primary_color')->nullable();
        $table->string('secondary_color')->nullable();
        $table->text('google_map_embed')->nullable();
        $table->json('social_media')->nullable();
        $table->string('copyright_text')->nullable();
        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
