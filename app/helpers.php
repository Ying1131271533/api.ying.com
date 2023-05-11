<?php

use App\Models\Category;
use App\Models\Citie;
use App\Models\Node;
use Illuminate\Support\Facades\Cache;

if (!function_exists('success')) {
    /**
     * 返回成功的api接口数据
     *
     * @param  array|string     $data           返回的数据
     * @param  int              $code           程序状态码
     * @param  int              $HttpStatus     http状态码
     * @param  string           $msg            描述信息
     * @return json                             api返回的json数据
     */
    function success($data = '', int $code = 200, int $HttpStatus = 200, string $msg = 'Success')
    {
        // 组装数据
        $resultData = [
            'code' => $code,
            'msg'  => $msg,
            'time' => time(),
            'data' => $data,
        ];

        // 如果$data是字符串
        // if (is_string($data)) {
        //     $resultData['msg']  = $data;
        //     $resultData['data'] = '';
        // }

        // 有分页数据
        if (isset($data['currentPage'])) {
            $resultData['total'] = $data['total'];
            $resultData['data']  = $data['data'];
        }

        // 返回数据
        return response()->json($resultData, $HttpStatus);
    }
}

if (!function_exists('fail')) {
    /**
     * 返回失败的api接口数据
     *
     * @param  string|array     $msg            描述信息
     * @param  int              $code           程序状态码
     * @param  int              $HttpStatus     http状态码
     * @return json                             api返回的json数据
     */
    function fail($msg = 'Error', int $code = 400, int $HttpStatus = 400)
    {
        // 组装数据
        $resultData = [
            'code' => $code,
            'msg'  => $msg,
            'time' => time(),
        ];
        // 返回数据
        return response()->json($resultData, $HttpStatus);
    }

}

if (!function_exists('cache_time')) {
    /**
     * 缓存时间
     *
     * @param   string      $type   返回时间戳类型
     * @return  integer             返回时间戳
     */
    function cache_time(string $type = 'dawn_rand_time')
    {
        switch ($type) {
            // 6小时
            case 'six_hour':
                $time = 3600 * 6;
                break;
            // 12小时 半天
            case 'half_day':
                $time = 3600 * 12;
                break;
            // 一天
            case 'one_day':
                $time = 3600 * 24;
                break;
            // 一周
            case 'one_week':
                $time = 3600 * 24 * 7;
                break;
            // 一个月
            case 'one_month':
                $time = 3600 * 24 * 30;
                break;
            // 一年
            case 'one_year':
                $time = 3600 * 24 * 365;
                break;
            // 随机 3-9 小时
            case 'rand_time':
                $time = rand(3600 * 3, 3600 * 9);
                break;
            // 凌晨0点
            case 'over_day':
                $time = 86400 - (time() + 8 * 3600) % 86400;
                break;
            // 凌晨3点
            case 'dawn_time':
                $time = 86400 - (time() + 8 * 3600) % 86400 + 3600 * 3;
                break;
            // 凌晨3点 + 一小时内的随机时间
            case 'dawn_rand_time':
                $time = 86400 - (time() + 8 * 3600) % 86400 + 3600 * 3 + rand(1, 3600);
                break;
            // 默认：凌晨3点 + 随机时间
            default:
                $time = 86400 - (time() + 8 * 3600) % 86400 + 3600 * 3 + rand(1, 3600);
                break;
        }

        return $time;
    }
}

if (!function_exists('get_children')) {
    /**
     * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
     * @author: 神织知更
     * @time: 2022/03/31 21:56
     *
     * 递归找子级数据
     *
     * @param  array    $data           二维数组
     * @param  int      $parent_id      父级id
     * @return array                    返回处理好的数组
     */
    function get_children(array $array = [], int $parent_id = 0)
    {
        $tmp = [];
        foreach ($array as $value) {
            if ($value['parent_id'] == $parent_id) {
                $value['children'] = get_children($array, $value['id']);
                $tmp[]             = $value;
            }
        }
        return $tmp;
    }

}

if (!function_exists('category_tree')) {
    /**
     * 树状分类
     *
     * @param   bool|int    $status     分类状态
     * @param   int         $level      分类层级
     * @return  array
     */
    function category_tree($group = 'goods', $status = false)
    // function category_tree($status = false, $level = 3)
    {
        $categorys = Category::with([
            'children' => function($qeury) use ($status){
                $qeury->when($status !== false, function($query) use ($status) {
                    $query->where('status', $status);
                })->select(['id', 'parent_id', 'name', 'level']);
            },
            'children.children' => function($qeury) use ($status){
                $qeury->when($status !== false, function($query) use ($status) {
                    $query->where('status', $status);
                })->select(['id', 'parent_id', 'name', 'level']);
            }
        ])
        ->when($status !== false, function($query) use ($status) {
            $query->where('status', $status);
        })
        ->where('group', $group)
        ->where('parent_id', 0)
        ->select(['id', 'parent_id', 'name', 'level'])
        ->get();

        return $categorys->toArray();


        // 拆分查询
        // $sql = Category::select(['id', 'parent_id', 'name', 'level'])
        // ->select(['id', 'parent_id', 'name', 'level']);
        // $sql->when($status !== false, function($query) use ($status) {
        //     $query->where('status', $status);
        // })
        // ->where('parent_id', 0);

        // if($level > 1){
        //     $sql->with([
        //         'children' => function($qeury) use ($status){
        //             $qeury->when($status !== false, function($query) use ($status) {
        //                 $query->where('status', $status);
        //             })->select(['id', 'parent_id', 'name', 'level']);
        //         }
        //     ]);
        // }

        // if($level > 2){
        //     $sql->with([
        //         'children.children' => function($qeury) use ($status){
        //             $qeury->when($status !== false, function($query) use ($status) {
        //                 $query->where('status', $status);
        //             })->select(['id', 'parent_id', 'name', 'level']);
        //         }
        //     ]);
        // }

        // $categorys = $sql->get();
        // return $categorys;


        // 递归
        // $categorys = Category::where('status', 1)->where('parent_id', 1)->get();
        // return get_children($categorys->toArray(), 1);
    }

}

if (!function_exists('cache_categorys')) {
    /**
     * 缓存没被禁用的分类
     *
     * @return  array
     */
    function cache_categorys()
    {
        $categorys = Cache::store('redis')->rememberForever('categorys_1', function() {
            return category_tree('goods', 1);
        });

        return $categorys;
    }

}

if (!function_exists('cache_categorys_all')) {
    /**
     * 缓存所有的分类
     *
     * @return  array
     */
    function cache_categorys_all()
    {
        $categorys = Cache::store('redis')->rememberForever('categorys', function() {
            return category_tree('goods');
        });
        return $categorys;
    }

}

if (!function_exists('forget_cache_category')) {
    /**
     * 清除分类缓存
     *
     * @return  array
     */
    function forget_cache_category()
    {
        Cache::store('redis')->forget('categorys');
        Cache::store('redis')->forget('categorys_1');
        Cache::store('redis')->forget('menus');
        Cache::store('redis')->forget('menus_1');
    }

}

if (!function_exists('cache_menus')) {
    /**
     * 缓存没被禁用的菜单
     *
     * @return  array
     */
    function cache_menus()
    {
        $menus = Cache::store('redis')->rememberForever('menus_1', function() {
            return category_tree('menu', 1);
        });

        return $menus;
    }

}

if (!function_exists('cache_menus_all')) {
    /**
     * 缓存所有的菜单
     *
     * @return  array
     */
    function cache_menus_all()
    {
        $menus = Cache::store('redis')->rememberForever('menus', function() {
            return category_tree('menu');
        });
        return $menus;
    }

}

if (!function_exists('oss_url')) {
    /**
     * 返回oss_url
     * @param  string   $url  路径
     *
     * @return  string
     */
    function oss_url($url)
    {
        // 如果没有url
        if(empty($url)) return '';

        // 如果$url包含了http等，是一个完整的地址，直接返回
        if(
            strpos($url, 'http://') !== false
            || strpos($url, 'https://') !== false
            || strpos($url, 'data:image') !== false
        ){
            return $url;
        }
        return config('filesystems.disks.oss.bucket_url') . '/' . $url;
    }
}


if (!function_exists('pay_type_name')) {
    /**
     * 返回支付类型
     * @param  string   $type  支付类型
     *
     * @return  string
     */
    function pay_type_name($type)
    {
        $pay_name = null;
        switch ($type) {
            case 1:
                $pay_name = '支付宝';
                break;
            case 2:
                $pay_name = '微信';
                break;
            default:
                break;
        }
        return $pay_name;
    }
}

if (!function_exists('make_code')) {
    /**
     * 返回验证码
     * @param  string   $length  验证码长度
     *
     * @return  string
     */
    function make_code($length = 6)
    {
        $max = pow(10, $length) - 1;
        $min = pow(10, $length - 1);
        return (string) rand($min, $max);
    }
}

if (!function_exists('cities_cache')) {
    /**
     * 获取所有城市
     */
    function cities_cache($parent_code = '000000')
    {
        return Cache::store('redis')->rememberForever('cities:'.$parent_code, function () use ($parent_code) {
            return Citie::where('parent_code', $parent_code)->get()->keyBy('code')->toArray();
        });
    }
}

if (!function_exists('cities_name')) {
    /**
     * 通过4级code，查询完整的省市县信息
     */
    function cities_name($citie_code)
    {
        $citie = Citie::where('code', $citie_code)->with('parent.parent.parent')->first();
        $array = [
            $citie->parent->parent->parent->name ?? '',
            $citie->parent->parent->name ?? '',
            $citie->parent->name ?? '',
            $citie->name ?? '',
        ];
        return trim(implode(' ', $array));
    }
}

