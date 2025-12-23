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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            
            $table->string('employee_code', 20)->unique();
            $table->string('first_name',100);
            $table->string('last_name',100);
            
            $table->string('email',150)->nullable()->unique();
            $table->string('phone',20)->nullable();
            $table->string('username')->unique();
            $table->text('password');
            $table->string('profile_image')->default('avatar.png');
            
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');   
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->date('hire_date')->nullable();     
            $table->string('status')->default('active');      
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};