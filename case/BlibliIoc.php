<?php
class Container {
    public static function getInstance($class_name,$params = []){
//获取反射实例
$reflector = new ReflectionClass($class_name);
//获取反射实例构造函数
$constructor = $reflector->getonstructor();//获取反射实例构造函数的形参
$d_params = [];
if ($constructor){
foreach ($constructor->getParameters () as $param) {
$class = $param->getclass();
if ($class){//如果参数是一个类,创建实例,并实例进行依赖注入
$d_params[] = self::getInstance($class->name);
}
}
}

//合并为数组
$d_params = array_merge($d_params,$params);//创建实例
return $reflector->newInstanceArgs($d_params);
}
}


//测试

class c {
    public $count = 20;
}
class A {
    public $count = 80;
    public function _construct(c $c){
        $this->count+=$c->count;
}
}

class B{
    protected $count = l;
    /*
    * B constructor.* @param int $count*/
    public function __construct(A $a,$count){
$this->count =$a->count + $count;
}
public function getCount(){
    return $this->count;
}
}
$b = Container::getInstance(B::class，[10]);
var_dump($b->getcount());
