<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressRequest;
use App\Models\Address;
use App\Transformers\AddressTransformer;

class AddressController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        $address = Address::where('user_id', auth('api')->id())->get();
        return $this->response->collection($address, new AddressTransformer);
    }

    /**
     * 添加
     */
    public function store(AddressRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth('api')->id();
        Address::create($validated);
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改
     */
    public function update(AddressRequest $request, $id)
    {
        //
    }

    /**
     * 删除
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 默认地址
     */
    public function default($id)
    {
        //
    }
}
