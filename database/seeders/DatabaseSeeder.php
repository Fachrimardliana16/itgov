<?php

namespace Database\Seeders;

use App\Models\Credential;
use App\Models\RkapPlan;
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

        // --- Module 3: RKAP Planner ---
        foreach ([
            ['RKAP-2026-001', 'Lisensi Antivirus Enterprise', 'Belanja Barang', 25000000, 18000000, 'tinggi', 'proses', 'Renewal Q3'],
            ['RKAP-2026-002', 'Server Rack & UPS', 'Belanja Modal', 65000000, 65000000, 'kritis', 'selesai', null],
            ['RKAP-2026-003', 'Internet Dedicated 500Mbps', 'Belanja Barang', 18000000, 5000000, 'sedang', 'disetujui', 'Kontrak 1 tahun'],
        ] as [$kode, $kegiatan, $kategori, $plan, $used, $prioritas, $status, $catatan]) {
            RkapPlan::create([
                'fiscal_year' => 2026, 'kode' => $kode, 'kegiatan' => $kegiatan, 'kategori' => $kategori,
                'belanja' => 'Langsung', 'planned_amount' => $plan, 'used_amount' => $used,
                'prioritas' => $prioritas, 'status' => $status, 'catatan' => $catatan,
            ]);
        }
    }
}
