<?php

namespace App\Http\Controllers;

use App\Jobs\RabbitJob;
use App\Models\Goods;
use App\Models\Mongo\Book;
use App\Services\Lib\RedisLock;
use Elastic\Client\ClientBuilderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
            if ($akali > 0) {
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
        $goods = Goods::search('苹果')
        // ->raw();
            ->get()
            ->toArray();
        // $goods = Goods::search()
        // ->query(fn (Builder $query) => $query->with('category')) // 关联模型
        // ->get();
        dd($goods);
    }

    public function mongo()
    {
        // $book = Book::find('64c76f02f78e0509130bd878');
        // return 1;
        // return Book::all();
        // $result = Book::create([
        //     'title' => '离群之刺 - 阿卡丽',
        //     'view_count' => 1,
        // ]);
        // $result = Book::create([
        //     'title' => '灵罗娃娃 - 格温',
        //     'view_count' => 2,
        // ]);
        $book = new Book();
        $data = [
            'title'      => '暴走萝莉 - 金克丝',
            'view_count' => 5,
        ];
        // 保存
        $book->fill($data)->save();
        // 保存作者
        $result = $book->author()->create([
            'name' => '神织知更',
        ]);
        return $result;
    }

    public function rabbitmq()
    {
        // 正常推送任务到 default 队列中
        RabbitJob::dispatch([
            'id'   => 1,
            'name' => '默认',
        ]);

        // 延时10秒推送到 akali 的队列
        RabbitJob::dispatch([
            'id'   => 2,
            'name' => '阿卡丽',
        ])->onQueue('akali')
        ->delay(now()->addSeconds(10));

        return '阿卡丽';
    }

    public function swoole()
    {
        phpinfo();
        return '格温';
    }
}
