<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Services\Lib\RedisLock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Elastic\Client\ClientBuilderInterface;

class TestController extends BaseController
{
    protected $client;
    public function __construct(ClientBuilderInterface $clientBuilder)
    {
        $this->client = $clientBuilder->default();
    }

    public function index(Request $request)
    {
        return ['name' => '阿卡丽'];
        // Redis::set('akali', 100);return 1;
        // 实例化redisLock
        $redisLock = new RedisLock();
        if ($redisLock->lockByLua()) {

            // 逻辑代码
            $akali = Redis::get('akali');
            if($akali > 0) {
                Redis::decr('akali');
            }

            // 释放锁
            $result = $redisLock->unlock();
            if (!$result) {
                return $this->response->errorBadRequest('抢购失败');
            }
        } else {
            return $this->response->errorBadRequest('抢购失败');
        }
        return $this->response->noContent();
    }

    public function es()
    {
        $params = [
            'index' => 'goods',
            'body' => [
                'query' => [
                    'nested' => [
                        'path' => 'attributes',
                        'query' => [
                            'bool' => [
                                'must' => [
                                    [
                                        'term' => [
                                            'attributes.name' => '适用季节'
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'attributes.value' => '夏季'
                                        ]
                                    ],
                                ],
                                'must' => [
                                    [
                                        'term' => [
                                            'attributes.name' => '布料'
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'attributes.value' => '棉66% 聚酯纤维34%'
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->client->search($params);
        $goods = $response['hits']['hits'];
        // 根据需要处理搜索结果
        dd($goods);

        $goods = Goods::search()
        // ->where('attributes.value', 'nested', function ($query) {
        //     $query->where('attributes.value', '夏季');
        // })
        // ->where('attributes.name', '适用季节')
        // ->where('title', '苹果')
        // ->where('attributes.value', '夏季')
        // ->raw();
        ->get()
        ->toArray();
        // $goods = Goods::search()
        // ->query(fn (Builder $query) => $query->with('category'))
        // ->get();
        dd($goods);
    }
}
