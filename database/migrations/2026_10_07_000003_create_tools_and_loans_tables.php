<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 50)->unique();
            $table->string('nama', 255);
            $table->string('kategori', 50);
            $table->string('status', 20)->default('tersedia');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('tool_loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('tool_id')->constrained('tools')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_rencana_kembali');
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->string('status', 20)->default('dipinjam');
            $table->text('catatan_pinjam')->nullable();
            $table->text('catatan_kembali')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_loans');
        Schema::dropIfExists('tools');
    }
};
