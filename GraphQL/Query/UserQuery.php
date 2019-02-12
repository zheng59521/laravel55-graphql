<?php
namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\MyUser;
use Illuminate\Support\Facades\DB;
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
     * 数据库字段 ? => 请求参数
     * */
    public function args() {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'username', 'type' => Type::string()],
            'pwd' => ['name' => 'pwd', 'type' => Type::string()],
            'jid' => ['name' => 'jid', 'type' => Type::int()]
        ];
    }

    public function resolve($root, $args) {
        $user = new MyUser();
        if (isset($args['id'])) { // 指定id时候
            $user = $user::where('id' , $args['id']);
        }
        else if (isset($args['username']) && isset($args['pwd']) ) { // 用户登录验证
            $code = 0;  // 验证用户名或密码
            $name = (string)$args['username'];
            $pwd = (string)$args['pwd'];
            $where = [
                'name' => $name,
                'pwd' => $pwd
            ];
            $userData = $user->where($where)->get();
            if ( !empty($user) ) { // 查出用户
                $token = $user->doLogin($user);
                $userData[0]['token'] = $token;
            } else { // 用户名|密码错误
                $code = 1;
            }
            $userData[0]['code'] = $code;
            return $userData;

        }
//        else if(isset($args['username'])) { // 指定name时候
//            $user = $user::where('name', $args['username'])->limit(10);
//        }
        else if(isset($args['jid'])) { // 指定name时候
            $user = $user::where('j_id', $args['jid'])->limit(10);
        }
        else {
            $user = $user->limit(10);
        }
        return $user->get();
    }
}