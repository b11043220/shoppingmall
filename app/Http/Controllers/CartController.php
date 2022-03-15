<?php

namespace App\Http\Controllers;

use App\Lib\Helper;
use App\Lib\Response;
use App\Models\Cart\ShoppingCart;
use App\Repository\BizRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $bizRepo;
    public function __construct(BizRepository $bizRepository)
    {
        $this->bizRepo = $bizRepository;
    }

    public function getCartItems(Request $request)
    {
        $cartItems = [];
        $list = $this->bizRepo->getCartItems(3);
        foreach ($list as $keys => $item) {
            $product = $this->bizRepo->getProductDtl($item['goods_id']);
            $tmp['id'] = $item['id'];
            $tmp['name'] = $product['title'];
            $tmp['price'] = $product['sale_price'];
            $tmp['quantity'] = $item['qty'];
            $tmp['imgPath'] = Helper::imageLink($product['thumb']);
            $tmp['checked'] = true;
            array_push($cartItems, $tmp);
        }
        return Response::output(Response::$ok, '', $cartItems);
    }

    public function deleteCartItem(Request $request)
    {
        $input = $request->all();
        $cartIds = json_decode($input['cartIds'], true);
        $this->bizRepo->deleteCartItem($cartIds);
        return Response::output(Response::$ok, '已删除');
    }

    public function updateCartQty(Request $request)
    {
        $input = $request->all();
        $cartId = $input['cartId'];
        $quantity = $input['quantity'];
        $this->bizRepo->updateCartQty($cartId, $quantity);
        return Response::output(Response::$ok, '已更新');
    }

    public function addCart(Request $request)
    {
        $data = $request->input();
        $cartObj = ShoppingCart::where('user_id', $data['userId'])
            ->where('goods_id', $data['productId'])
            ->first();
        if ($cartObj) {
            $cartObj->qty += $data['quantity'];
            $cartObj->save();
        } else {
            $cartId = ShoppingCart::insertGetId([
                'user_id' => $data['userId'],
                'product_id' => $data['productId'],
                'qty' => $data['quantity'],
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        return Response::output(Response::$ok, '已加入购物车');
    }
}
