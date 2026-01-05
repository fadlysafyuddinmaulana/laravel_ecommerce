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
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // 'about', 'services', etc.
            $table->string('section_key'); // 'hero_title', 'hero_content', 'feature_1_title', etc.
            $table->text('content');
            $table->string('content_type')->default('text'); // 'text', 'html', 'image', 'url'
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Create composite index for faster lookups
            $table->index(['page_name', 'section_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
