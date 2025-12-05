<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_variations_id',
        'qty',
        'price',
        'total',
        'shipping',
        'subtotal',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function productVariation(){
        return $this->belongsTo(ProductVariation::class , 'product_variations_id');
    }

}
