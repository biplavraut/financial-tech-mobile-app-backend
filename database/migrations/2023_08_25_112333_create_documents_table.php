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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kyc_id');
            $table->enum('type', ['citizenship', 'passport','license', 'pan', 'voter_id', 'national_id', 'birth_certificate', 'other'])->default('other');
            $table->string('number')->nullable();
            $table->string('office_of_issuance')->nullable();
            $table->date('date_of_issue')->nullable();
            $table->string('issue_district')->nullable();
            $table->string('front')->nullable();
            $table->string('back')->nullable();
            $table->string('selfiee')->nullable();
            $table->date('valid_till')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
