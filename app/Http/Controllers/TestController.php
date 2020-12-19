<?php

namespace App\Http\Controllers;


use App\Model\Students;
use Illuminate\Http\Request;

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


}
