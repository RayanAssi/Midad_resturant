<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'amount', 'date', 'user_id'])]
class Expense extends Model     // ← مفرد
{
    protected $casts = [
        'amount' => 'decimal:2',
        'date'   => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}