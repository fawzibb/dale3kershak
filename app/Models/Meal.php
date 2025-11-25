<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_available'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getPriceLLAttribute()
{
    $rate = Setting::first()->exchange_rate ?? 90000;
    return $this->price * $rate;
}
}
