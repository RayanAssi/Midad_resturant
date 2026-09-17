<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'type','notes', 'total_amount', 'table_no', 'address'])]

class Order extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
public function orderItems(): HasMany
{
    return $this->hasMany(OrderItem::class);
}

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoices::class);
    }
    
    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'order_items')
            ->withPivot(['quantity', 'price', 'subtotal'])
            ->withTimestamps();
    }
}
