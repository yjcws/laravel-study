<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Grade;
use App\Model\GradeStudent;

class Students extends Model
{
    //
    //

    public $connection='mysql';
    public $primaryKey='id';
    public $timestamps = false;
    //多对多
    public function grade()
    {
        // 1. 关联模型  2. 中间表  3.指定操作表对应中间表的关联外键  4. 指定关模模型对应中间表的关联外键
        return $this->belongsToMany(Grade::class, 'grade_students', 'student_id', 'grade_id');
    }

    //远程一对多
    public function Grad()
    {
        // 1. 关联模型名 2.中间模型  3.当前操作模型对于到中间模型的外键名 4. 关联模型的外键名  5. 操作模型的外键名  6. 中间模型对应于本地键名
        return $this->hasManyThrough(Grade::class, GradeStudent::class, 'student_id' , 'id' ,'id' ,'grade_id');
    }
}
