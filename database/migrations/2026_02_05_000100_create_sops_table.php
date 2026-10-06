<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sops', function (Blueprint $table) {
            $table->uuid('id')->primary();               // UUID v4 sebagai primary key
            $table->string('code', 50)->unique();          // Contoh: SOP-IT-001
            $table->string('title', 255);                  // Not NULL
            $table->string('category', 50);                // Infrastructure, Security, Development, Helpdesk, General
            $table->text('content');                       // HTML / Markdown
            $table->string('version', 20)->default('1.0.0');
            $table->string('status', 20)->default('draft'); // draft, review, approved, archived
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('attachment_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sops');
    }
};