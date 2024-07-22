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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kyc_id');
            $table->enum('relation', ['spouse', 'father', 'mother', 'grand_father', 'grand_mother', 'son', 'daughter', 'daughter_in_law', 'father_in_law', 'mother_in_law']);
            $table->string('full_name')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->string('place_of_issue')->nullable();
            $table->string('date_of_issue')->nullable();
            $table->string('contact')->nullable();
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
        Schema::dropIfExists('families');
    }
};
