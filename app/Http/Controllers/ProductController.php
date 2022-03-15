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

        $productList = $this->bizRepo->getProductByCateId($cateId, $pageSize, $offset);
        foreach ($productList as $key => $product) {
            $productList[$key]['thumb'] = Helper::imageLink($product['thumb']);
            $bannerImgs = $product['bannerimgs'];
            $captionImgs = $product['captionimgs'];

            $banners = [];
            foreach ($bannerImgs as $bannerImg) {
                array_push($banners, Helper::imageLink($bannerImg));
            }
            $productList[$key]['banners'] = $banners;

            $captions = [];
            foreach ($captionImgs as $captionImg) {
                array_push($captions, Helper::imageLink($captionImg));
            }
            $productList[$key]['captions'] = $captions;
        }
        return Response::output(Response::$ok, '获取成功', $productList);
    }
}
