<?php

namespace App\Models;

use App\Casts\EncryptedAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetPlan extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetPlanFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'fiscal_year',
        'code',
        'title',
        'category',
        'budget_type',
        'planned_amount',
        'used_amount',
        'priority',
        'status',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'fiscal_year' => 'integer',
            'planned_amount' => 'decimal:2',
            'used_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}