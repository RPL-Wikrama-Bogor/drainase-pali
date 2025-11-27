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
        Schema::create('office_roads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drainage_id')->constrained('drainages');
            $table->string('position');
            $table->integer('segment');
            $table->integer('loc_x');
            $table->integer('loc_y');
            $table->string('status');
            $table->string('type');
            $table->string('type_of_shape');
            $table->string('dimension');
            $table->string('material');
            $table->string('material_condition');
            $table->string('length');
            $table->string('image');
            $table->text('notes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_roads');
    }
};
