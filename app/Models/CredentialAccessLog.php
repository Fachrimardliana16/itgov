<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['credential_id', 'user_id', 'action', 'ip_address', 'user_agent', 'created_at'])]
class CredentialAccessLog extends Authenticatable
{
    /** @use HasFactory<CredentialAccessLogFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'credential_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
    ];

    public function credential(): BelongsTo
    {
        return $this->belongsTo(Credential::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}