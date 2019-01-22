<?php

namespace App\GraphQL\Type;

use GraphQL;
use Graphql\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType {

    /*
     * 定义查询信息
     * 查询名称,
     * 查询介绍
     * */
    protected $attributes = [
        'name' => 'user',
        'description' => '用户信息',
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
            'name' => [
                'type' => Type::string(),
                'description' => '用户名',
            ],
            'job' => [
                'type' => Type::listOf(GraphQL::type('job')),
                'description' => '工作'
            ]
        ];
    }

    /*
     * If you want to resolve the field yourself, you can declare a method
     * with the following format resolve[FIELD_NAME]Field()
     * 对返回的字段进行处理
     * */
    protected function resolveNAMEField($root, $args) {
        return (string)strtolower('用户名为 '.$root->name);
    }
}