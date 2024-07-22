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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('kyc_code')->unique();
            $table->string('salutation')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('dob_bs')->nullable();
            $table->date('dob_ad')->nullable();
            $table->boolean('self')->default(0);
            $table->boolean('other')->default(0);
            $table->string('pp_photo')->nullable();
            $table->string('map')->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->boolean('kyc_verified')->default(0);
            
            $table->boolean('peps_member')->default(0);
            $table->string('peps_detail')->nullable();
            $table->boolean('beneficial')->default(0);
            $table->string('beneficial_name')->nullable();
            $table->string('beneficial_ctzn_no')->nullable();
            $table->string('beneficial_relation')->nullable();
            $table->string('beneficial_address')->nullable();
            $table->string('beneficial_contact')->nullable();

            $table->text('decleration')->nullable();
            $table->text('additional_note')->nullable();
            $table->enum('status', ['received', 'processing', 'invalid', 'valid', 'rejected', 'archive', 'verified'])->default('received');
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};
