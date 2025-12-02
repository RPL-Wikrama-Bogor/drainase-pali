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
        Schema::create('drainase_images', function (Blueprint $table) {
             $table->id();
            $table->string('identifier')->unique(); // Identifier dari GeoJSON
            $table->string('nama_ruas')->nullable(); // Nama ruas drainase
            $table->string('filename'); // Nama file gambar
            $table->string('path'); // Path lengkap gambar
            $table->string('original_name'); // Nama asli file
            $table->string('mime_type'); // Tipe file
            $table->integer('size'); // Ukuran file dalam bytes
            $table->text('description')->nullable(); // Deskripsi gambar
            $table->timestamps();
            $table->softDeletes();
            $table->index(['identifier', 'nama_ruas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drainase_images');
    }
};
