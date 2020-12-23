<?php
/**
 * Created by PhpStorm.
 * User: Winner
 * Date: 2019/6/6 0006
 * Time: 22:18
 */
interface Milldeware
{
    public static function handle(Closure $next);
}
class  VerifyCsrfToken implements Milldeware{
    public static function handle(Closure $next)
    {
       echo '验证CSRF token<br>';
       $next();
    }
}
class  VerifyAuth implements Milldeware{
    public static function handle(Closure $next)
    {
        echo '验证用户是否登录<br>';
        $next();
    }
}
class  SetCookie implements Milldeware{
    public static function handle(Closure $next)
    {
        echo '设置cookie信息<br>';
        $next();

    }
}
$handle = function (){
  echo '当前要执行中间件操作';
};
function Millde()
{
    SetCookie::handle(function (){
        VerifyAuth::handle(function (){
            global  $handle;
            VerifyCsrfToken::handle($handle);
        });
    });
}
Millde();