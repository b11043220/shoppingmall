<?php

namespace App\Models\Product;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use DefaultDatetimeFormat;

    protected $table = "mall_category";
    protected $guarded = [];

    public function scopePid($query, $pid)
    {
        return $query->where('pid', $pid);
    }
}
