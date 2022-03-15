<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Lib\Response;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Repository\BizRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function getProductDtl(Request $request): array
    {
        $productId = $request->get('productId');
        $product = $this->bizRepo->getProductDtl($productId);
        $detail['title'] = $product['title'];
        $detail['subTitle'] = $product['sub_title'];
        $detail['marketPrice'] = $product['market_price'];
        $detail['salePrice'] = $product['sale_price'];
        $banners = $product['bannerimgs'];
        foreach ($banners as $keys => $banner) {
            $imgPath = Helper::imageLink($banner);
            $banners[$keys] = $imgPath;
        }
        $captions = $product['captionimgs'];
        foreach ($captions as $keys => $caption) {
            $imgPath = Helper::imageLink($caption);
            $captions[$keys] = $imgPath;
        }
        $detail['banners'] = $banners;
        $detail['captions'] = $captions;

        $recommend = [];
        $list = Product::limit(6)->get()->toArray();
        foreach ($list as $product) {
            $tmp = [];
            $thumb = Helper::imageLink($product['thumb']);
            $tmp['imgPath'] = $thumb;
            $tmp['productId'] = $product['id'];
            $tmp['title'] = $product['title'];
            $tmp['marketPrice'] = $product['market_price'];
            $tmp['salePrice'] = $product['sale_price'];
            array_push($recommend, $tmp);
        }

        dd(json_encode($detail));

        return Response::output(Response::$ok, '获取成功', [
            'detail' => $detail,
            'recommend' => $recommend
        ]);
    }
}
