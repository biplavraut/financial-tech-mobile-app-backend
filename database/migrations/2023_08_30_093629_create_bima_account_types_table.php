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
        Schema::create('bima_account_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bima');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('account_type');
            $table->string('image')->nullable();
            $table->boolean('display')->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('bima')->references('id')->on('bimas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bima_account_types');
    }
};