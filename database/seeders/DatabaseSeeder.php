<?php

namespace Database\Seeders;

use App\Models\BudgetPlan;
use App\Models\Credential;
use App\Models\Sop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // --- Users & Roles ---
        $admin = User::create([
            'name' => 'Admin IT',
            'email' => 'admin@itgov.local',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_blocked' => false,
        ]);

        User::create([
            'name' => 'Staff IT',
            'email' => 'staff@itgov.local',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'is_blocked' => false,
        ]);

        // --- Module 1: IT SOP Documentation ---
        Sop::create([
            'code' => 'SOP-IT-001',
            'title' => 'Prosedur Backup Server Bulanan',
            'category' => 'Infrastructure',
            'content' => '<h1>Prosedur Backup Server</h1><p>Lakukan backup penuh setiap akhir bulan ke NAS offsite.</p>',
            'version' => '1.0.0',
            'status' => 'approved',
            'author_id' => $admin->id,
            'approved_by' => $admin->id,
        ]);

        Sop::create([
            'code' => 'SOP-IT-002',
            'title' => 'Incident Response Plan',
            'category' => 'Security',
            'content' => '<h1>IRP</h1><p>Dokumen langkah-langkah penanganan insiden keamanan.</p>',
            'version' => '1.0.0',
            'status' => 'draft',
            'author_id' => $admin->id,
        ]);

        // --- Module 2: Credential Vault (auto-encrypted via cast) ---
        $c = Credential::create([
            'title' => 'Server DB Production',
            'category' => 'Database',
            'host_or_url' => 'db.internal:5432',
            'username_encrypted' => 'root_admin',
            'password_encrypted' => 'S3cr3t!Passw0rd',
            'additional_secret_encrypted' => 'PGP-Key-ABCD-1234',
            'notes_encrypted' => 'Kredensial utama database produksi',
        ]);
        // auditable log CREATE
        $c->accessLogs()->create([
            'user_id' => $admin->id,
            'action' => 'CREATE',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'seeder',
        ]);

        Credential::create([
            'title' => 'API Key Payment Gateway',
            'category' => 'SaaS',
            'host_or_url' => 'https://api.gateway.example.com',
            'username_encrypted' => 'pgw_client',
            'password_encrypted' => 'pgw_secret_key_2026',
            'notes_encrypted' => null,
        ]);

        // --- Module 3: IT Annual Budget Planner ---
        BudgetPlan::create([
            'fiscal_year' => 2026,
            'code' => 'BGT-2026-001',
            'title' => 'Lisensi Antivirus Enterprise',
            'category' => 'License',
            'budget_type' => 'OPEX',
            'planned_amount' => 25000000,
            'used_amount' => 18000000,
            'priority' => 'high',
            'status' => 'in_progress',
            'notes' => 'Renewal Q3',
        ]);

        BudgetPlan::create([
            'fiscal_year' => 2026,
            'code' => 'BGT-2026-002',
            'title' => 'Server Rack & UPS',
            'category' => 'Hardware',
            'budget_type' => 'CAPEX',
            'planned_amount' => 65000000,
            'used_amount' => 65000000,
            'priority' => 'critical',
            'status' => 'completed',
            'notes' => null,
        ]);

        BudgetPlan::create([
            'fiscal_year' => 2026,
            'code' => 'BGT-2026-003',
            'title' => 'Internet Dedicated 500Mbps',
            'category' => 'Internet_Cloud',
            'budget_type' => 'OPEX',
            'planned_amount' => 18000000,
            'used_amount' => 5000000,
            'priority' => 'medium',
            'status' => 'approved',
            'notes' => 'Kontrak 1 tahun',
        ]);
    }
}