<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'spesifikasi',
        'kondisi',
        'lokasi',
        'tanggal_beli',
        'nilai',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_beli' => 'date',
            'nilai' => 'decimal:2',
        ];
    }
}
