<?php

namespace App\Http\Controllers;


use App\Model\Students;
use Illuminate\Http\Request;
use App\Model\User;

class TestController extends Controller
{
    //
    //
    //
    public function index() {
        return 'App\Http\Controllers\TestController.php';
    }

    public function checkRoute() {
        return 'checkRoute';
    }

    public function cookie()
    {
        //是不可以
        #cookie('name', 'winner');
        #第一种
        // setcookie('name' , 'Winner老师最帅');

        #第二种
        /*return response('响应数据结果')->cookie('name1', '奋斗,迎娶白富美');*/
        #第三种
        /* $cookie = cookie('name', 'winner', 10);
         return response('第三种方式')->cookie($cookie);*/
        #第四种
        Cookie::queue('name2', 45445565665, 5);
    }

    public function getCookie()
    {
        $value  = request()->cookie('name1');
        $values = Cookie::get('name2');
        dump($value,$values);
    }
    //视图操作
    public function checkView()
    {
        $bool = View::exists('blog/index');
        dd($bool);
    }

    public function tans()
    {
        //默认自动提交,   抛出异常就回滚
        /* $data = DB::transaction(function (){
             $bool = DB::update("update tp_user set user_name = 'lol' where uid = ?", [63]);
             $bool1 = DB::update("update tp_user set user_name = 'winner' where uid = ?", [45]);
         throw new \Exception('操作有错误');
         });*/
        //手动提交事务
        #开始事务
        DB::beginTransaction();
        $bool = DB::update("update tp_user set user_name = 'lol' where uid = ?", [63]);
        $bool1 = DB::update("update tp_user set user_name = 'winner' where uid = ?", [45]);
        if (empty($bool) || empty($bool1)) {
            echo '自己回滚';
            DB::rollBack();
        }else {
            echo '直接提交';
            DB::commit();
        }
    }

    public function select()
    {
        //where  模式是等于条件
        //$resutl = DB::table('tp_user')->where('uid', '>',63)->get();
        /*  $resutl = DB::table('tp_user')->where([
              ['uid', '>', 63],
              ['role_id', '>', 2],
          ])->get();*/
        /*$resutl = DB::table('tp_user')->where([
            'uid' => 63,
            'role_id' => 2,
        ])->get();*/

        /* dump($resutl);*/
    }

    public function chunk()
    {
        /*DB::table('tp_user')->orderBy('uid')->chunk(3, function ($citys){
            foreach ($citys as $city){
             echo $city->uid. 'user_name:   '.$city->user_name.'<br>';
             break;
            }
        });*/
        $result = DB::table('tp_user')->orderBy('uid')->where('uid', 63)->select('uid', 'user_name')->addSelect('user_password')->first();
        dump($result);
    }

    public function join()
    {
        /*$result = DB::table('tp_user')
            //join 1. 关联表表名   2.操作表关联字段  3. 条件  4.关联表的关联字段
                  ->join('tp_user_role', 'tp_user.role_id', '=', 'tp_user_role.role_id')->first();*/
        /*$result = DB::table('tp_user')
                  ->join('tp_user_role', 'tp_user.role_id', '=', 'tp_user_role.role_id')
                  ->join('tp_user_group', 'tp_user_role.group_id_array', '=' , 'tp_user_group.group_id')
                  ->first();*/
        /* $result = DB::table('tp_user')
             //关联表需要条件限制,自己传入闭包
             ->join('tp_user_role', function ($role){
                 $role->on('tp_user.role_id', '=', 'tp_user_role.role_id')
                        ->where('tp_user_role.group_id_array', 55);
             })
             ->first();*/
        /* $result = DB::table('tp_user')
             ->leftjoin('tp_user_role','tp_user.role_id', '=', 'tp_user_role.role_id')
             ->first();*/
        //子查询
        $result =  DB::table('tp_user')
            ->select('uid','role_id as role', DB::raw('MAX(instance_id) as Max_id'))
            ->where('is_system', '=', 1)
            ->groupBy('role');

        $users =  DB::table('tp_user_role')
            //子查询
            ->joinSub($result, 'latest_posts', function ($join){
                $join->on('tp_user_role.role_id', '=', 'latest_posts.role');
            })->select('tp_user_role.role_id', 'tp_user_role.role_name')->get();
        dump($users);
    }

    public function order()
    {
        $result = DB::table('tp_user')->orderBy('uid', 'desc')->get();
        //latest(desc) 最新数据   oldest(ASC)  最老数据   默认使用created_at
        $result = DB::table('tp_user')->latest('uid')->get();
        dump($result);
    }
    public function limit()
    {
        //offset 偏移量   limit  限制查询数量
        $result1 = DB::table('tp_user')->offset(2)->limit(3)->get();
        //skip <=====>offset 1   take<====>limit 3
        $result2 = DB::table('tp_user')->skip(1)->take(3)->get();
        dump($result1, $result2);
    }

    public function insert()
    {
        /*$result = DB::table('tp_user')->insert([
            'user_name' => '胡连平',
            'role_id' => 1,
        ]);*/
        //批量插入
        /*  $data = [
             [
                 'user_name' => '月亮',
                 'role_id' => 1],
             [ 'user_name' => '伪学生的青春',
                 'role_id' => 1],
             [
                 'user_name' => 'like',
                 'role_id' => 1],
          ];
          $result = DB::table('tp_user')->insert($data);*/
        //获取自增id

        /*$id =  DB::table('tp_user')->insertGetid([
            ['user_name' => '海军',
            'role_id' => 1],
        ]);*/
        $update =  DB::table('tp_user')->where('role_id', 5) ->update(['user_name'=>'待续']);
        dump($update);
    }

    public function redis()
    {
        $user = Redis::set('name', 'winner');
        $name = Redis::get('name');
        dump($user, $name);
    }

    public function model()
    {
        //获取所有(结果默认是对象,  结果要数组请调用toArray)
        $data = User::all();
        //数据的结果集
        $arr = User::all()->toArray();
        //获取单条数据  基于主键查询
        $find = User::find(1);
        $find = User::get();
        #新增|修改 (save)的内容
        $userModel = new User();
        $userModel->name = 'test';
        $userModel->email = '196454665@126.com';
        $userModel->password = '8888@dd';
        $bool = $userModel->save();
        //多条基于insert
        $bool  = User::insert([
            'name' => 'test1',
            'email' => '467877@126.com',
            'password' => 'e5r34345',
        ]);
        //修改模型
        //$bool = User::where('id', 5)->update(['name' => 'winner']);
        $userModel = User::find(4);
        $userModel->email = '455445@.swcc';
        $bool = $userModel->save();
        dump($bool);
        //删除  delete
        $bool = User::where('id' ,'=', '4')->delete();
        dump($bool);
        $data = User::all()->toArray();
        dump($data);
        //withTrashed 获取包含软删除模型数据
        $data = User::withTrashed()->get()->toArray();
        dump($data);
        //onlyTrashed  只是获取软删除的模型
        $data = User::onlyTrashed()->get()->toArray();
        dump($data);
        //恢复状态 restore
        $data = User::onlyTrashed()->where('id',4)->restore();
        dump($data);
        //真实删除数据
        $bool = User::onlyTrashed()->where('id',4)->forceDelete();
        dump($bool);
    }

    public function relevance()
    {
        //一对一
        //$data = Users::find(290)->userRole;
        /*$data = Users::with('userRole:role_id,role_name')->get(['uid','user_name', 'role_id'])->toArray();
        dump($data);*/
        //反向关联
        # $data = UserRole::find(2)->user;
        //一对多关联
        /*   $data = UserRole::find(1)->userMany;
           dump($data);*/
        //多对多关联
        /*  $data = Student::find(2)->grade;
          dump($data);*/
        //远程一对多
        /*$data = Student::find(2)->Grad;
        dump($data);*/


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
