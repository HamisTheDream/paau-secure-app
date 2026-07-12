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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('matric_number')->unique();
        $table->string('department');
        $table->string('level');
        $table->string('phone_number')->nullable();
        $table->date('dob')->nullable();
        $table->string('fees_status')->default('Unpaid'); // e.g., Paid, Unpaid, Partial
        $table->string('security_status')->default('None'); // None, Wanted, Investigated, Suspended, Withdrawn
        $table->string('profile_picture')->nullable(); // Stores the path to the image
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
