<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RkapPlan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'fiscal_year',
        'kode',
        'kegiatan',
        'kategori',
        'belanja',
        'planned_amount',
        'used_amount',
        'prioritas',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'fiscal_year' => 'integer',
            'planned_amount' => 'decimal:2',
            'used_amount' => 'decimal:2',
        ];
    }
}
