<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Good;
use App\Models\Spec;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SpecService
{
    public static function saveSpec($data, $model = null)
    {
        // 获取模型
        $spec = $model ? $model : new Spec();

        // 取出规格项
        $spec_items = array_unique($data['spec_items']); // 数组去重

        // 开启事务
        DB::beginTransaction();
        try {

            // 如果是更新，则处理规格项的数组
            if(isset($spec->id)) {
                // 找到旧的items
                $old_spec_items = $spec->items->pluck('name')->toArray();

                // $spec_items 与 $old_spec_items 数组的差集 为删除数据
                $add_items = array_diff($spec_items, $old_spec_items);

                // $old_spec_items 与 $spec_items 数组的差集 为新增数据
                $del_items = array_diff($old_spec_items, $spec_items);

                // 删除数据
                $spec->items()->whereIn('name', $del_items)->delete();
                // 重新赋值
                $spec_items = $add_items;
            }

            // 保存商品规格
            $result = $spec->fill($data)->save();
            if(!$result) throw new BadRequestException('保存商品规格失败！');


            // 保存规格项
            $items = [];
            foreach ($spec_items as $spec_item) {
                $items[] = ['name' => $spec_item];
            }
            $result = $spec->items()->createMany($items);
            if(!$result) throw new BadRequestException('保存商品规格项失败！');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    /*
		// 数组选项组合递归方法的思想
		$array = [
			[1, 2, 3],
			['a', 'b', 'c'],
			['e', 'f', 'g'],
		];

        // 有几排规格，就要for循环几次
		foreach($array[0] as $key => $value)
		{
			foreach($array[1] as $ke => $val)
			{
				foreach($array[2] as $k => $v)
				{
					$temp[] = $value . '_' . $val . '_' . $v;
				}
			}
		}

		dump($temp);
	*/
    /**
     * 通过递归处理套餐组合
     */
	public static function getHandleSpecGroup($itemsArray, $temp = [])
	{
        // 如果是空，则跳出整个递归
		if(empty($itemsArray)) return false;

        // 接收所有套餐组合
		static $data = [];

		// 先取出数组的第一项，并且删除第一项
		$fristArray = array_shift($itemsArray);

		// 遍历得到第一项数组
		foreach($fristArray as $key => $value)
		{
			$temp[] = $value;
			self::getHandleSpecGroup($itemsArray, $temp);
			if(empty($itemsArray))
			{
				$data[] = $temp;
			}
            // 这里是删除第一个套餐[1, a, e]的e，再把[1, a]传到第二个套餐里面，变成[1, a, f]
            // 不然的话，会把最后一个规格['e', 'f', 'g']，全部排到后面去，例如：[1, a, e, f, g]
            // 所以在把$temp传到下一个规格时，需要把上一次的最后一个值删除
			array_pop($temp);
		}

		return $data;
	}
}
