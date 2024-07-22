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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('order');
            $table->boolean('display')->default(0);
            $table->boolean('locker')->default(0);
            $table->boolean('atm')->default(0);
            $table->boolean('head_office')->default(0);
            $table->unsignedBigInteger('district')->nullable();
            $table->unsignedBigInteger('municipality')->nullable();
            $table->unsignedBigInteger('province')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('branches');
    }
};
