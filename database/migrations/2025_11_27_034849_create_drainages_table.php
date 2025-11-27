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
        Schema::create('drainages', function (Blueprint $table) {
            $table->id();
            $table->string('name_road');
            $table->string('road_function');
            $table->double('length_sk');
            $table->double('length_km');
            $table->double('length_m');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drainages');
    }
};
