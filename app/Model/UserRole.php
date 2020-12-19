<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use App\Model\User;

class UserRole extends Model
{
    //
    protected $primaryKey = 'role_id';

    //方向关联
    public function user()
    {
        // 相对关联   1.关联表  2.关联模型外键字段  3.操作模型外键
        return $this->belongsTo(User::class, 'role_id','id');

    }
//    //一对多关联
//    public function userMany()
//    {
//        // 一对多关联   1.关联表  2.关联模型外键字段  3.操作模型外键
//        return $this->hasMany(Users::class, 'role_id', 'role_id');
//    }
}
