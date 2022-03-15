<?php

namespace App\Models\Product;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use DefaultDatetimeFormat;

    protected $table = "mall_product";
    protected $guarded = [];

    public function getBannerimgsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setBannerimgsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['bannerimgs'] = json_encode($value);
        }
    }

    public function getCaptionimgsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCaptionimgsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['captionimgs'] = json_encode($value);
        }
    }

    public function scopeCateId($query, $categoryId)
    {
        return $query->where('cate_id', $categoryId);
    }
}
