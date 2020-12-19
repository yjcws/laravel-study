<?php

namespace App\Http\Controllers;


use App\Model\Students;
use Illuminate\Http\Request;
use App\Model\User;

class TestController extends Controller
{
    //
    //
    public function index(){

    	return '首页';
    }


    public function test(){

    	return '首页2';
    }

    //远程一对多
    public function grade()
    {

        $data = Students::find(2)->Grad;

        dd($data);

    }


    public function with()
    {
        //预加载
      foreach (User::all() as $key => $value){

          //echo '123';
                 echo $value->userRole();
                 //dd($value);
         }
        //wtih
//        foreach (Users::with('userRole')->get() as  $key => $value) {
//            echo $value->userRole. '<br>';
//        }
    }

    public function attr()
    {
        //echo '123';
        //获取器
         $filed = User::get('role_id')->toArray();
         var_dump($filed);
        //修改器
//        $user = User::find(63);
//        $user->user_name = 'SDFDSF';
//        dump($user);
    }

}
