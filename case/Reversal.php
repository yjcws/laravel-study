<?php
/**
 * Created by PhpStorm.
 * User: Winner
 * Date: 2019/5/30 0030
 * Time: 22:27
 */
class A
{
    protected  $ioc;
    public function __construct(Ioc $ioc)
    {
        $this->ioc = $ioc;
    }
    public function getB()
    {
        return $this->ioc->make('b');
    }
}
class  Ioc
{
    protected $instances = [];
    public function __construct($name = null)
    {
        $this->instances['a'] = new A($this);
        $this->instances['b'] = new B($this);
    }
    public function make (string $abstract)
    {
        return  $this->instances[$abstract];
    }
}
class B
{
    protected  $ioc;
    public function __construct(Ioc $ioc)
    {
        $this->ioc = $ioc;
    }
}
//绑定对象实例关系
$ioc = new Ioc();
//注册实例
/*$a = $ioc->make('a');
var_dump($a);
$b = $a->getB();
var_dump($b);*/

//反射
$reflector = new reflectionClass(Ioc::class);
var_dump($reflector);
//构造函数
$constructor = $reflector->getConstructor();
var_dump($constructor);
//IOC构造函数的参数
$dependencies = $constructor->getParameters();
var_dump($dependencies);