<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 19-1-21
 * Time: 下午1:51
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class MyUser extends Model
{
     protected $table = 'user';

    public function job()
    {
        return $this->hasOne('App\Models\Job', 'id', 'j_id');
    }

    public function doLogin ( $data)  {
        $token = '';
        $token = $this->encryptTOKEN($data['id']);
        return $token;
    }

    /*
     * 生成token
     * */
    private function  encryptTOKEN ($id) {
        $id = md5($id);
        $time = time();
        $token = base64_encode("{$id}-{$time}");
        return $token;
    }

    /*
     * 解析token,
     * 判断当前token状态
     * 0 => token过期或即将过期
     * 1 => token正常
     * */
    public function decryptTOKEN ($token) {
        $str = base64_decode($token);
        $dataArr = explode('-', $str);
        $id = $dataArr[0];
        $login_time = $dataArr[1];
        $now = time();
        $arr = [
            'id' => $id,
            'login_time' => $login_time,
            'status' => 1
        ];
        if ( $now - $login_time >= 1800 + 0 ) { // 测试阶段token半小时过期(后期需要判断,快过期的时候也要重置token,快过期的时间为x秒)
            $arr['status'] = 0;     // 过期
        }
        return $arr;
    }
}