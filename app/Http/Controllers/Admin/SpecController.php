<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\SpecRequest;
use App\Models\Spec;
use App\Services\Admin\SpecService;
use App\Transformers\SpecTransformer;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SpecController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        // 条件
        $include = $request->query('include');
        $name = $request->query('name');
        $limit = $request->query('limit');
        // 获取数据
        $specs = Spec::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })
        ->paginate($limit)
        ->appends([
            'include' => $include,
            'name' => $name,
            'limit' => $limit,
        ]);
        return $this->response->paginator($specs, new SpecTransformer);
    }

    /**
     * 添加
     */
    public function store(SpecRequest $request)
    {
        // 验证数据
        $validated = $request->validated();
        // 保存数据
        SpecService::saveSpec($validated);
        return $this->response->created();
    }

    /**
     * 详情
     */
    public function show(Spec $spec)
    {
        return $this->response->item($spec, new SpecTransformer);
    }

    /**
     * 更新
     */
    public function update(SpecRequest $request, Spec $spec)
    {
        // 验证数据
        $validated = $request->validated();
        // 更新数据
        SpecService::saveSpec($validated, $spec);
        return $this->response->noContent();
    }

    /**
     * 删除
     */
    public function destroy(Spec $spec)
    {
        try {
            $spec->items()->delete();
            $spec->delete();
            return $this->response->noContent();
        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * 检索
     */
    public function isIndex(Spec $spec)
    {
        $spec->is_index = $spec->is_index == 0 ? 1 : 0;
        $result = $spec->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function sort(SpecRequest $request, Spec $spec)
    {
        // 验证的数据
        $validated = $request->validated();
        // 更新数据
        $spec->sort = $validated['sort'];
        $result = $spec->save();
        if(!$result) return $this->response->errorInternal();
        return $this->response->noContent();
    }

    /**
     * 排序
     */
    public function handleSpecGroup(SpecRequest $request)
    {
        // 接收的数据的格式：1是商品规格id 5和6是规格项id
        // $spec_items = [ '1_5', '1_6', '1_7', '2_10', '2_11' ];

        // 接收商品规格项
        $spec_items = $request->input('spec_items', []);
        if(empty($spec_items)) throw new UnprocessableEntityHttpException('数据不能为空');

        // 处理数据
        // 把上面的数据变成这样：[ 1 => [ 5, 6, 7 ], 2 => [ 10, 11 ] ]
        $specArray = [];
		foreach($spec_items as $items)
		{
			$temp = explode('_', $items);
			$specArray[$temp[0]][] = $temp[1];
		}

        // 获取处理好的规格套餐
        $spec_group = SpecService::getHandleSpecGroup($specArray);
        return $this->response->array($spec_group);
    }
}
