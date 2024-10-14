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
        Schema::create('building_parkings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('days')->nullable();
            $table->boolean('price')->nullable();
            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_parkings');
    }
};
