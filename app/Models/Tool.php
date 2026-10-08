<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'status',
        'catatan',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(ToolLoan::class);
    }

    public function currentLoan(): ?ToolLoan
    {
        return $this->loans()->where('status', 'dipinjam')->latest()->first();
    }
}
