<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['title', 'amount', 'date'])]

class Expenses extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
}
