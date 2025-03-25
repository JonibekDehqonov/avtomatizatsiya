<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category_id', 
        'image',
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    } 
}
