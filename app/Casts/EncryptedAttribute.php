<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Custom Eloquent Cast: AES-256-GCM encryption (via Laravel Crypt).
 * Auto-encrypt saat disimpan, auto-decrypt saat dibaca.
 */
class EncryptedAttribute implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return \Illuminate\Support\Facades\Crypt::decryptString($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return \Illuminate\Support\Facades\Crypt::encryptString($value);
    }
}