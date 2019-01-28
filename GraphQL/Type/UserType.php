<?php

namespace App\GraphQL\Type;

use GraphQL;
use Graphql\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Models\MyUser;
use App\Models\Job;

class UserType extends GraphQLType {

    /*
     * 定义查询信息
     * 查询名称,
     * 查询介绍 
     * */
    protected $attributes = [
        'name' => 'user',
        'description' => '用户信息',
        'model' => MyUser::class
    ];

    /*
     * 定义返回字段信息
     * */
    public function fields () {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => '用户id',
            ],
            'username' => [
                'type' => Type::string(),
                'description' => '用户名',
            ],
            'jid' => [
                'type' => Type::int(),
                'description' => '关联id'
            ],
            'job' => [
                'args' => [
                    'job_id' => [
                        'type' => Type::int(),
                        'description' => '工作id'
                    ],
                    'job_name' => [
                        'type' => Type::string(),
                        'description' => '工作名称'
                    ]
                ],
                'type' => Type::listOf(GraphQL::type('job')),
                'description' => '工作'
            ]
        ];
    }

//    ------------------------------------------------
    /*
     * resolve***Field方法
     * 1.对返回字段进行关联数据库字段操作 (例如给数据库字段起个别名)
     * 2.对返回的字段进行处理
     * */

    /*
     * username => user.name
     * */
    protected function resolveUSERNAMEField($root, $args) {
        return (string)strtolower('用户名为 '.$root->name);
    }

    /*
     * jid => user.j_id
     * */
    protected function resolveJIDField($root, $args) {
        return (int) $root->j_id;
    }

    /*
     * job => jobTable
     * */
    public function resolveJOBField($root, $args) {
        $job = $root->job();
        if (isset($args['job_id'])) {
            $job->where('id', $args['job_id']);
        }
        if (isset($args['job_name'])) {
            $job->where('name', $args['job_name']);
        }
        return $job->get();
    }

//    --------------------------------------------------



}