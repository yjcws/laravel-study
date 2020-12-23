<?php
/**
 * Created by PhpStorm.
 * User: Winner
 * Date: 2019/6/6 0006
 * Time: 20:34
 */
/**
 * 1. IOC容器会用binding数组记录bind方法绑定关系
 * 2. 反射类去拿到操作类的构造函数  参数  方法等
 * 3. 反射创建操作对象
 */
//定义支付接口
interface pay
{
    public function payment();
}
//支付宝支付
class AliPay implements pay
{
    public function payment()
    {
        // TODO: Implement payment() method. 待定事项
        echo '我是支付宝支付';
    }
}
//微信支付
class WXPay implements pay
{
    public function payment()
    {
        // TODO: Implement payment() method.   paypal
        echo '我是微信支付';
    }
}
class Order
{
    protected $pay;
    public function __construct(Pay $pay)
    {
        $this->pay = $pay;
    }
    public function success()
    {
        echo '支付成功';
        $this->pay->payment();
    }
}
class  Ioc
{
  public $bindings = [];
  //绑定关系
    public function bind($abstract, $concrete)
    {
        if (!$concrete instanceof Closure)
        {
            $concrete = function ($ioc) use ($concrete) {
                //通过容器的放射类拿到对象
                return $ioc->build($concrete);
            };
        }
        $this->bindings[$abstract]['concrete'] =  $concrete;
    }
    //取出对象
    public function make($abstract)
    {
       // 更加key获取bindings的值
        $concrete = $this->bindings[$abstract]['concrete'];
        return $concrete($this);
    }
    //创建对象
    public function build($concrete)
    {
        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();
        if (is_null($constructor))
        {
            return $reflector->newInstance();
        }else {
            $dependencies = $constructor->getParameters();
            $instances = $this->getDependencies($dependencies);
            return $reflector->newInstanceArgs($instances);
        }
    }
    protected function getDependencies($paramters) {
        $dependencies =  [];
        foreach ($paramters as $paramter) {
            $dependencies[] = $this->make($paramter->getClass()->name);
        }
        return $dependencies;
    }
}
//实例化
/*$ioc = new Ioc();
$ioc->bind('pay','WXPay');
$ioc->bind('order', 'Order');
$order = $ioc->make('order');
$order->success();*/

class OrderFacade
{
    protected static $ioc;

    /**
     * @return mixed
     */
    public static function setFacadeIoc($ioc)
    {
        return self::$ioc = $ioc;
    }

    protected static function getFacadeAccessor()
    {
        return 'order';
    }
    public static function __callStatic($method, $arguments)
    {
       $instance = static::$ioc->make(static::getFacadeAccessor());
       return $instance->$method(...$arguments);
    }
}
//静态调用
$ioc = new Ioc();
$ioc->bind('pay', 'AliPay');
$ioc->bind('order', 'Order');
OrderFacade::setFacadeIoc($ioc);

OrderFacade::success();