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
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_type')->default('free'); // Free or premium
            $table->unsignedInteger('likes_received')->default(0); // Count of likes received
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('subscription_type')->default('free'); // Free or premium
            $table->unsignedInteger('likes_received')->default(0); // Count of likes received
        });
    }
};
