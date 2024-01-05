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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('value');
            $table->enum('type', ['Percent', 'Nominal']);
            $table->bigInteger('min_price');
            $table->bigInteger('max_discount')->nullable();
            $table->bigInteger('max_used')->nullable();
            $table->bigInteger('used');
            $table->enum('status', ['ON', 'OFF']);
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
