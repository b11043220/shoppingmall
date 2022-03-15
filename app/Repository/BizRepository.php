<?php

namespace App\Repository;

use App\Models\Cart\ShoppingCart;
use App\Models\Product\Category;
use App\Models\Product\Product;

class BizRepository extends BaseRepository
{
    public function getCategory($pid=null, $columns=['*'])
    {
        return Category::pid($pid)->select($columns)->get()->toArray();
    }

    public function getProductByCateId($cateId,$pageSize, $offset, $columns=['*'])
    {
        return Product::cateId($cateId)
            ->offset($offset)
            ->limit($pageSize)
            ->select($columns)
            ->get()
            ->toArray();
    }

    public function getProductDtl($productId, $columns=['*'])
    {
        return Product::where('id', $productId)->select($columns)->first()->toArray();
    }

    public function getCartItems($userId, $columns=['*'])
    {
        return ShoppingCart::select($columns)->get()->toArray();
    }

    public function deleteCartItem($cartId)
    {
        return ShoppingCart::destroy($cartId);
    }
}
