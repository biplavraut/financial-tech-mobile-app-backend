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
        Schema::create('occupations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kyc_id');
            $table->enum('type', ['government', 'private','public', 'student', 'teacher_professor', 'self', 'other'])->default('other');
            $table->string('office')->nullable();
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('est_annual_income')->nullable();
            $table->string('est_annual_turnover')->nullable();
            $table->string('tel')->nullable();
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
        Schema::dropIfExists('occupations');
    }
};
