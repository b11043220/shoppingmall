<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Lib\Response;
use App\Models\Product\Category;
use App\Repository\BizRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $bizRepo;
    public function __construct(BizRepository $bizRepository)
    {
        $this->bizRepo = $bizRepository;
    }

    /**
     * @return array
     */
    public function getCategory()
    {
        $category = [];
        $tops = $this->bizRepo->getCategory();
        foreach ($tops as $k=>$v) {
            $category[$k]['cateId'] = $v['id'];
            $category[$k]['cateName'] = $v['name'];
            $subCate = [];
            $subCates = $this->bizRepo->getCategory($v['id']);
            foreach ($subCates as $i => $item) {
                $subCate[$i]['subCateId'] = $item['id'];
                $subCate[$i]['subCateName'] = $item['name'];
                $subCate[$i]['imgPath'] = Helper::imageLink($item['thumb']);
            }
            $category[$k]['subCateLst'] = $subCate;
        }
        return Response::output(Response::$ok, '获取成功', $category);
    }

    public function getProductsByCateId(Request $request)
    {
        $data = $request->input();
        $pageSize = 20;
        $page = isset($data['page']) ?? 1;
        $offset = ($page-1)*$pageSize;
        $cateId = $data['cateId'];

        $productList = [];
        $list = $this->bizRepo->getProductByCateId($cateId, $pageSize, $offset);
        foreach ($list as $key => $product) {
            $tmp = [];
            $thumb = Helper::imageLink($product['thumb']);
            $tmp['imgPath'] = $thumb;
            $tmp['productId'] = $product['id'];
            $tmp['title'] = $product['title'];
            $tmp['marketPrice'] = $product['market_price'];
            $tmp['salePrice'] = $product['sale_price'];
            array_push($productList, $tmp);
        }
        return Response::output(Response::$ok, '获取成功', $productList);
    }
}
