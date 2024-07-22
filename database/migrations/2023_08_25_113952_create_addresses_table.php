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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kyc_id');
            $table->enum('type', ['permanent', 'current'])->default('permanent');
            $table->string('province_no')->nullable();
            $table->string('province')->nullable();
            $table->string('zone')->nullable();
            $table->string('district')->nullable();
            $table->string('vdc_municipality')->nullable();
            $table->string('ward')->nullable();
            $table->string('street_tole')->nullable();
            $table->string('house_no')->nullable();
            $table->string('tel')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kyc_id')->references('id')->on('kycs')->onDelete('cascade');
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
