<?php

namespace App\Models;

use App\Casts\EncryptedAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credential extends Model
{
    /** @use HasFactory<\Database\Factories\CredentialFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'category',
        'host_or_url',
        'username_encrypted',
        'password_encrypted',
        'additional_secret_encrypted',
        'notes_encrypted',
    ];

    protected function casts(): array
    {
        return [
            // Zero plaintext: semua field sensitif auto-encrypt saat simpan, decrypt saat baca
            'username_encrypted' => EncryptedAttribute::class,
            'password_encrypted' => EncryptedAttribute::class,
            'additional_secret_encrypted' => EncryptedAttribute::class,
            'notes_encrypted' => EncryptedAttribute::class,
        ];
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(CredentialAccessLog::class);
    }
}