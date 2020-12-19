<?php
/**
 * Created by PhpStorm.
 * User: Winner
 * Date: 2019/5/30 0030
 * Time: 22:22
 */
//控制正转
class  A1
{
    //存储对象
    protected  $b;
    public function __construct()
    {
        $this->b = new B1();
    }
    public function getB()
    {
        return $this->b;
    }
}
class B1
{
    public function __construct()
    {
    }

    public function test()
    {
        return '我是控制正转的测试方法';
    }
}
$b = (new A1) -> getB();
var_dump($b);
var_dump($b->test());