<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rkap_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('fiscal_year');
            $table->string('kode', 50)->unique();
            $table->string('kegiatan', 255);
            $table->string('kategori', 50);
            $table->string('belanja', 50);
            $table->decimal('planned_amount', 15, 2)->default(0);
            $table->decimal('used_amount', 15, 2)->default(0);
            $table->string('prioritas', 20)->default('sedang');
            $table->string('status', 20)->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rkap_plans');
    }
};
