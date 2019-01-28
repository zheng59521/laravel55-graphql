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
}