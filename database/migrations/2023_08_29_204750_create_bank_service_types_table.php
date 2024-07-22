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
        Schema::create('bank_service_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('service_type');
            $table->string('image')->nullable();
            $table->boolean('display')->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('bank')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_service_types');
    }
};
