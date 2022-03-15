<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = "mall_cart";
    protected $guarded = [];

    public function scopeUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
