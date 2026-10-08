<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ToolLoan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tool_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali_aktual',
        'status',
        'catatan_pinjam',
        'catatan_kembali',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_rencana_kembali' => 'date',
            'tanggal_kembali_aktual' => 'date',
            'user_id' => 'integer',
        ];
    }

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
