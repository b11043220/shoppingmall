<?php

namespace App\Http\Controllers;

use App\Lib\Response;
use App\Models\User\Address;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAddressList(Request $request)
    {
        $data = $request->input();
        $list = Address::where('user_id', $data['userId'])->get()->toArray();
        foreach ($list as $keys => $item) {
            $list[$keys]['isDefault'] = $item['is_default']==1;
        }
        return Response::output(Response::$ok, '获取成功', $list);
    }
}
