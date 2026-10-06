<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->uuid('id')->primary();               // UUID v4 sebagai primary key
            $table->string('title', 255);
            $table->string('category', 50);                // Server, Database, Network, SaaS, ServiceAccount
            $table->string('host_or_url', 255)->nullable();
            $table->string('username_encrypted', 255);     // WAJIB di-encrypt
            $table->string('password_encrypted', 255);     // WAJIB di-encrypt
            $table->string('additional_secret_encrypted', 255)->nullable(); // API Keys, SSH Keys, PIN
            $table->string('notes_encrypted', 255)->nullable();                 // Catatan rahasia
            $table->timestamps();
        });

        Schema::create('credential_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credential_id')->constrained('credentials')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action', 50);                  // VIEW_PASSWORD, CREATE, UPDATE, DELETE
            $table->string('ip_address', 45);              // IPv4 atau IPv6
            $table->text('user_agent');                    // Browser/User-Agent string
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credential_access_logs');
        Schema::dropIfExists('credentials');
    }
};