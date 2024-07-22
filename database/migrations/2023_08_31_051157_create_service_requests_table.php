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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->string('service');
            $table->string('title')->nullable();
            $table->bigInteger('title_id')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('type_id')->nullable();
            $table->unsignedBigInteger('kyc');
            $table->text('description')->nullable();
            $table->text('form_fields')->nullable();
            $table->boolean('display')->default(0);
            $table->enum('status', ['received', 'processing', 'invalid', 'valid', 'rejected', 'archive', 'verified', 'completed'])->default('received');
            $table->string('additional_note')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
