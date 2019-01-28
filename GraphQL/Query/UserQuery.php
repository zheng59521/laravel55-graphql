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

    public function args() {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args) {
        $user = new MyUser();
        if (isset($args['id'])) { // 指定id时候
            $user = $user::where('id' , $args['id']);
        } else if(isset($args['name'])) { // 指定name时候
            $user = $user::where('name', $args['name'])->limit(10);
        } else {
            $user = $user->limit(10);
        }
        return $user->get();
    }
}