<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\UserRole;

class User extends Model
{
    //
    protected $primaryKey = 'id';
    //访问器 get + 字段 + Attribute
    public function getRoleIdAttribute($value)
    {
        $data = [
            1 => '超级管理员',
            2 => '编辑',
            3 => '客服',
            4 => '客服5',
            5 => '客服6',
            0 => '客服6',
        ];
        return $data[$value];
    }
    //修改器
    public function setUserNameAttribute($value)
    {
        $this->attributes['user_name']  = strtolower($value);
    }
    public function userRole()
    {
        // 1. 关联表  2.关联表外键字段   3.操作表外键
        return $this->hasOne(UserRole::class, 'role_id','id');
    }
}
