<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 19-1-22
 * Time: 上午10:59
 */

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class JobQuery extends Query
{

    /*
     * 定义查询名称
     * */
    protected $attributes = [
        'name' => 'job'
    ];

    /*
     * 指定与之关联的type
     * */
    public function type() {
        return Type::listOf(GraphQL::type('job'));
    }

    /*
     * 定义返回的字段信息
     * */
    public function args() {
        return [
            'id' => ['name'=>'id', 'type'=>Type::int()],
            'job_name' => ['name' => 'job_name', 'type'=> Type::string()]
        ];
    }

}