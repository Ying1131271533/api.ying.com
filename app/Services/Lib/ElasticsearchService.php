<?php
namespace App\Services\Lib;

// 用于商品搜索
class ElasticsearchService
{
    /**
     * 搜索结构体
     * @var array
     */
    protected $params = [
        'type' => '_doc',
        'body' => [
            'query' => [
                'bool' => [
                    'filter' => [],
                    'must'   => [],
                ],
            ],
        ],
    ];

    /**
     * 通过构造函数进行索引初始化
     * ElasticsearchService constructor.
     * @param $index
     */
    public function __construct($index)
    {
        //要搜索的索引名称
        $this->params['index'] = $index;

        return $this;
    }

    /**
     * 根据字段-条件搜索
     * @param $type .搜索类型：term精准搜索，match分词器模糊查询，prefix字段前缀
     * @param $key  .搜索的字段名称
     * @param $value.搜索字段值
     * @return $this
     */
    public function queryByFilter($type, $key, $value)
    {
        $this->params['body']['query']['bool']['filter'][] = [$type => [$key => $value]];

        return $this;
    }

    /**
     * 关键词按照权重进行搜索
     * @param $keyWords
     * @return $this
     */
    public function keyWords($keyWords)
    {
        //如果不是数据则转换为数组
        $keyWords = is_array($keyWords) ? $keyWords : [$keyWords];

        foreach ($keyWords as $key => $value) {
            $this->queryByMust($value);
        }
        return $this;
    }

    /**
     * 根据权重进行多字段搜索
     * @param $seach 搜索的值
     * @return $this
     */
    public function queryByMust($seach)
    {
        $this->params['body']['query']['bool']['must'][] = ['multi_match' => [
            'query'  => $seach,
            // 'fields' => ['long_name^3', 'category^2'], // 数字越大，权重越大
            'fields' => ['title^3'],
        ]];

        return $this;
    }

    /**
     * 获取指定字段
     * @param $keyWords  一维数组
     * @return $this
     */
    public function source($keyWords)
    {
        $keyWords = is_array($keyWords) ? $keyWords : [$keyWords];

        $this->params['body']['_source'] = $keyWords;

        return $this;
    }

    /**
     * 设置分页
     * @param $page
     * @param $pageSize
     * @return $this
     */
    public function paginate($page, $pageSize)
    {
        $this->params['body']['from'] = ($page - 1) * $pageSize;

        $this->params['body']['size'] = $pageSize;

        return $this;
    }

    /**
     * 排序
     * @param $filed        .排序字段
     * @param $direction    .排序值
     * @return $this
     */
    public function orderBy($filed, $direction)
    {
        if (!isset($this->params['body']['sort'])) {
            $this->params['body']['sort'] = [];
        }

        $this->params['body']['sort'][] = [$filed => $direction];

        return $this;
    }

    /**
     * 聚合查询 商品属性筛选的条件
     * @param $name     属性名称
     * @param $value    属性值
     * @return $this
     */
    public function attributeFilter($name, $value)
    {
        //attributes 为 索引中的  attributes  字段
        $this->params['body']['query']['bool']['filter'] = [
            'nested' => [
                'path'  => 'attributes',
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'term' => [
                                    'attributes.name' => $name,
                                ],
                            ],
                            [
                                'term' => [
                                    'attributes.value' => $value,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this;
    }

    /**
     * 聚合查询(方式2) 商品属性筛选的条件
     * @param $name
     * @param $value
     * @return $this
     */
    /*public function attributeFilter($name,$value){
    $this->params['body']['query']['bool']['filter'][] = [
    'nested' => [
    'path'  => 'attributes',
    'query' => [
    ['term' => ['attributes.name' => $name]],
    ['term' => ['attributes.value' => $value]]
    ],
    ],
    ];

    return $this;
    }*/

    /**
     * 返回结构体
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 多维数组转换一维数组
     * @param $input
     * @param $flatten
     * @return array
     */
    public static function getDataByEs($input)
    {
        $total = $input['hits']['total']['value'];
        $input = $input['hits']['hits'];

        $data = collect($input)->pluck('_source');

        return [$data, $total];
    }

}
