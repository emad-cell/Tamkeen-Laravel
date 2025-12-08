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
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // links to users table
            $table->string('full_name');
            $table->string('mobile_number');
            $table->boolean('accepted');
            $table->string('lisence');
            $table->string('file_path')->nullable(); // e.g. uploaded CV, profile pic, etc.
            $table->string('image')->nullable(); // e.g. uploaded CV, profile pic, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
