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
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('plan');
            $table->date('start_date');
            $table->string('car_brand');
            $table->string('model');
            $table->string('color');
            $table->string('license_plate');
            $table->string('email')->nullable();
            $table->integer('phone_number')->nullable();
            $table->integer('otp')->nullable();
            $table->string('transaction_id')->nullable();

            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
