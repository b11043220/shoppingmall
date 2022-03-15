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

    public function updateAddress(Request $request)
    {
        $data = $request->input();
        $default = $data['default']?1:0;
        if ($default) {
            Address::where('user_id', $data['userId'])->update(['is_default' => 0]);
        }

        $addressId = $data['addressId'];
        $updated['name'] = $data['name'];
        $updated['mobile'] = $data['mobile'];
        $updated['address'] = $data['address'];
        $updated['is_default'] = $default;
        Address::where('id', $addressId)->update($updated);
        return Response::output(Response::$ok, '已更新');
    }

    public function deleteAddressItem(Request $request)
    {
        $input = $request->all();
        $addressId = $input['addressId'];
        Address::destroy($addressId);
        return Response::output(Response::$ok, '已删除');
    }

    public function addAddress(Request $request)
    {
        $input = $request->all();
        $default = $input['default']?1:0;
        if ($default) {
            Address::where('user_id', $input['userId'])->update(['is_default' => 0]);
        }
        $addressId = Address::insertGetId([
            'user_id' => $input['userId'],
            'name' => $input['name'],
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'is_default' => $default,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return Response::output(Response::$ok, '已添加');
    }
}
