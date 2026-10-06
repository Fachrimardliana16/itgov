<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sop extends Model
{
    /** @use HasFactory<\Database\Factories\SopFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'title',
        'category',
        'content',
        'version',
        'status',
        'author_id',
        'approved_by',
        'attachment_path',
    ];

    protected $casts = [
        'author_id' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}