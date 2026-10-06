<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();               // UUID v4 sebagai primary key
            $table->integer('fiscal_year');                // Contoh: 2026
            $table->string('code', 50)->unique();          // Contoh: BGT-2026-001
            $table->string('title', 255);                  // Not NULL
            $table->string('category', 50);                // License, Hardware, SLA_Maintenance, Internet_Cloud, Training
            $table->string('budget_type', 10);             // CAPEX, OPEX
            $table->decimal('planned_amount', 15, 2)->default(0.00);  // Not NULL
            $table->decimal('used_amount', 15, 2)->default(0.00);      // Not NULL
            $table->string('priority', 20)->default('medium'); // low, medium, high, critical
            $table->string('status', 20)->default('proposed'); // proposed, approved, rejected, in_progress, completed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_plans');
    }
};