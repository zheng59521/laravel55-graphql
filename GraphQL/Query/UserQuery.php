<?php
namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\MyUser;
class UserQuery extends Query
{
    /*
     * 定义查询信息
     * 名称
     * */
    protected $attributes = [
        'name' => 'user',
    ];

    public function type() {
        return Type::listOf(GraphQL::type('user'));
    }


    /*
     * 数据库字段 => 请求参数
     * */
    public function args() {
        return [
            'id' => ['name' => '_id', 'type' => Type::int()],
            'name' => ['name' => '_name', 'type' => Type::string()],
            'j_id' => ['name' => '_jid', 'type' => Type::int()]
        ];
    }

    public function resolve($root, $args) {
        $user = new MyUser();
        if (isset($args['_id'])) { // 指定id时候
            $user = $user::where('id' , $args['_id']);
        } else if(isset($args['_name'])) { // 指定name时候
            $user = $user::where('name', $args['_name'])->limit(10);
        } else if(isset($args['_jid'])) { // 指定name时候
            $user = $user::where('j_id', $args['_jid'])->limit(10);
        } else {
            $user = $user->limit(10);
        }
        return $user->get();
    }
}