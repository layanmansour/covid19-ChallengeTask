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
        Schema::create('countries', function (Blueprint $table) {
            $table->string('slug')->primary();
            $table->string('country');
            $table->string('country_code');
            $table->integer('new_confirmed');
            $table->integer('total_confirmed');
            $table->integer('new_deaths');
            $table->integer('new_recovered');
            $table->integer('total_deaths');
            $table->integer('total_recovered');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
