<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\AddressRequest;
use App\Models\Address;
use App\Transformers\AddressTransformer;
use Illuminate\Support\Facades\DB;
use LaravelLang\Publisher\Console\Add;

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
    public function show(Address $address)
    {
        return $this->response->item($address, new AddressTransformer);
    }

    /**
     * 修改
     */
    public function update(AddressRequest $request, Address $address)
    {
        $validated = $request->validated();
        $address->update($validated);
        return $this->response->noContent();
    }

    /**
     * 删除
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return $this->response->noContent();
    }

    /**
     * 默认地址
     */
    function default(Address $address) {

        // 是否已经是默认地址
        if($address->is_default == 1) {
            return $this->response->errorBadRequest('当前地址已经是默认地址');
        }

        try {
            DB::beginTransaction();
            // 获取原先的默认地址
            $defaultAddress = Address::where('user_id', auth('api')->id())
                ->where('is_default', 1)
                ->first();
            if (!empty($defaultAddress)) {
                $defaultAddress->is_default = 0;
                $defaultAddress->save();
            }

            // 再设置当前地址为默认
            $address->is_default = 1;
            $address->save();

            DB::commit();
            return $this->response->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
