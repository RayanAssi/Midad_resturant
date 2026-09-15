<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'image', 'price', 'category'])]

class MenuItem extends Model
{
    protected $casts = [
        'price' => 'decimal:2',
    ];

    public static function categories(): array
    {
        return ['appetizer', 'main_course', 'dessert', 'beverage'];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image
            ? Storage::url($this->image)
            : asset('images/placeholder.png')
        );
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->category) {
            'appetizer'   => 'Appetizer',
            'main_course' => 'Main Course',
            'dessert'     => 'Dessert',
            'beverage'    => 'Beverage',
            default       => ucfirst($this->category),
        });
    }
}