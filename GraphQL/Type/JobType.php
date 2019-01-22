<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 19-1-22
 * Time: 上午10:49
 */

namespace App\GraphQL\Type;

use App\Models\Job;
use Graphql\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;


class JobType extends GraphQlType
{

    /*
     * 定义类型信息
     * */
    protected $attributes = [
        'name' => 'job',
        'description' => '工作',
        'model' => Job::class
    ];

    /*
     * 定义返回字段信息
     * */
    public function fields () {
        return [
            'job_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => '工作id'
            ],
            'job_name' => [
                'type' => Type::string(),
                'description' => '工作名称'
            ]
        ];
    }

    /*
     * 返回字段与数据库关联
     * */
    public function resolveJOBIDField ($root, $args) {
        return (int) $root->id;
    }

    public function resolveJOBNAMEField ($root, $args) {
        return (string) '我的工作是 '.$root->name;
    }
}