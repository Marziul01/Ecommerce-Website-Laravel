<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityRequest extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id',
        'product_id',
        'variation_id',
        'quantity',
        'remaining_qty',
        'buy_price',
        'date',
        'message',
        'status',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function productVariation(){
        return $this->belongsTo(ProductVariation::class , 'variation_id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
