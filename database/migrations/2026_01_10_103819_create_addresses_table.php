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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('country')->index(); // e.g., "INDONESIA"
            $table->string('province')->index(); // e.g., "DKI JAKARTA"
            $table->string('city')->index(); // e.g., "Jakarta Pusat"
            $table->string('postal_code', 10)->nullable(); // e.g., "10110"
            $table->text('street_address')->nullable(); // Full street address
            $table->string('label')->default('home'); // home, office, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};