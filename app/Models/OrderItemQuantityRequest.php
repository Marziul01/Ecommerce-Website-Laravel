<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemQuantityRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'quantity_request_id',
        'qty_used',
        'buy_price',
        
    ];
}
