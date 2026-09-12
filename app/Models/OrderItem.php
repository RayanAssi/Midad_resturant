<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['order_id', 'menu_order_id', 'quantity'])]

class OrderItem extends Model
{
    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    public function menuOrder(): BelongsTo
    {
        return $this->belongsTo(Menu_orders::class);
    }
}
