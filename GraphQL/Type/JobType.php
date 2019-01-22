<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 19-1-22
 * Time: 上午10:49
 */

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQlType;

class JobType extends GraphQlType
{

    /*
     * 定义类型信息
     * */
    protected $attributes = [
        'name' => 'job',
        'description' => '工作',
    ];

    /*
     * 定义返回字段信息
     * */
    public function fields () {
        return [
            'id' => [
                'name' => Type::nonNull(Type::int()),
                'description' => '工作id'
            ],
            'job_name' => [
                'name' => Type::string(),
                'description' => '工作名称'
            ],
        ];
    }

}