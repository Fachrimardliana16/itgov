<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('budget_plans')) {
            return;
        }

        $priority = ['low' => 'rendah', 'medium' => 'sedang', 'high' => 'tinggi', 'critical' => 'kritis'];
        $status = ['proposed' => 'diajukan', 'approved' => 'disetujui', 'rejected' => 'ditolak', 'in_progress' => 'proses', 'completed' => 'selesai'];

        foreach (DB::table('budget_plans')->get() as $b) {
            DB::table('rkap_plans')->insert([
                'id' => (string) Str::uuid(),
                'fiscal_year' => $b->fiscal_year,
                'kode' => $b->code,
                'kegiatan' => $b->title,
                'kategori' => $b->budget_type === 'CAPEX' ? 'Belanja Modal' : 'Belanja Barang',
                'belanja' => 'Langsung',
                'planned_amount' => $b->planned_amount,
                'used_amount' => $b->used_amount,
                'prioritas' => $priority[$b->priority] ?? 'sedang',
                'status' => $status[$b->status] ?? 'draft',
                'catatan' => $b->notes,
                'created_at' => $b->created_at,
                'updated_at' => $b->updated_at,
            ]);
        }

        Schema::drop('budget_plans');
    }

    // ponytail: one-way merge; restore budget_plans from backup if rollback is needed.
    public function down(): void {}
};
