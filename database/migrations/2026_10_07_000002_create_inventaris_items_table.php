<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 50)->unique();
            $table->string('nama', 255);
            $table->string('kategori', 50);
            $table->text('spesifikasi')->nullable();
            $table->string('kondisi', 20)->default('Baik');
            $table->string('lokasi', 255)->nullable();
            $table->date('tanggal_beli')->nullable();
            $table->decimal('nilai', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris_items');
    }
};
