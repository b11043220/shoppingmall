<?php

namespace App\Repository;

use App\Models\Product\Category;
use App\Models\Product\Product;

class BizRepository extends BaseRepository
{
    public function getCategory($pid=null, $columns=['*'])
    {
        return Category::pid($pid)->select($columns)->get()->toArray();
    }

    public function getProductByCateId($cateId, $columns=['*'])
    {
        return Product::cateId($cateId)->select($columns)->get()->toArray();
    }
}
