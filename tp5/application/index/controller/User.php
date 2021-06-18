<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\db\Where;
use think\facade\Session;
use think\facade\Request;
//引入User 模型
use app\index\model\User as UserModel;

class User extends Controller
{

        //通过模型获取用户信息
        public function test1()
        {
            $num = UserModel::where('user_id',60)->find();
            echo "<pre>";
            echo print_r($num);
            echo "</pre>";
//            $num = UserModel::where('user_id',6)->find();
//            echo "<pre>";
//            echo print_r($num);
//            echo "</pre>";
            echo "<hr>";
            echo "用户名：  " . $num->user_name;
            echo "<hr>";
            echo "password：  " . $num->password;
        }
        //向表中添加信息
        public function test2 ()
        {
            $num = new UserModel;
            $num->user_name =  'zhangsang111';
            $num->email = 'zhangsang111@qq.com';
            $num->mobile = '16619914544';
            $number = $num->save();
            var_dump($number);
        }

        //get post 接收的两种方式
        public function test3 ()
        {
           // $num = $this->request->param();
            echo "get的name参数是：" .Request::param('name');echo "<br>";
//            echo "<pre>";
//            echo print_r($num);
//            echo "</pre>";
            return $this->fetch();
        }
        public function form1()
        {
            //原始post接收 表单传参
            echo "<pre>";
            echo print_r($_POST);
            echo "</pre>";
            echo "<hr>";

            //php 标准接收post传参
            echo "<pre>";
            echo print_r($this->request->param());
            echo "</pre>";
        }










        //注册
        public function reg ()
        {
          return $this->fetch();
        }
        //注册接收逻辑
        public function gg (){
            echo "<pre>";
            echo print_r($_POST);
            echo "</pre>";
            $user_name = $_POST['user_name'];
            $user_email = $_POST['user_email'];
            $user_mobile = $_POST['user_mobile'];
            $password = $_POST['password'];
            $data = [
                'user_name' => $user_name,
                'email' => $user_email,
                'mobile' => $user_mobile,
                'password' => $password
             ];
            //往数据库添加数据
            $list = Db::table('p_users')->insert($data);
            if($list){
                echo "数据添加成功";
            }else {
                echo "数据添加失败";
            }
        }


        //登录
        public function log ()
        {
            return $this->fetch();
        }
        //登录接收 逻辑
        public function dl ()
            {
            $name = $_POST['name'];
            $pass = $_POST['password'];
            $u = Db::table('p_users')->where('user_name',$name)->find();
            if ($u){
                //判断密码
                if($pass == $u['password']){
                    //登录记录历史
                    $date = [
                        'datauid'  =>  $u['user_id'],
                        'datatime' =>  time(),
                        'dataip'   =>  $_SERVER['REMOTE_ADDR'],
                        'dataua'   =>  $_SERVER['HTTP_USER_AGENT'],
                    ];
                    Db::table('ppp')->insert($date);

                    //把user_id 存到session里
                    session::set('user_id',$u['user_id']);
                    session::set('user_name',$u['user_name']);
                    echo "登录成功";
                    //登录成功后条到个人中心 center 页面
                    return redirect('center');

                }else {
                    echo "密码错误";
                    return redirect("/login");
                    die;
                }
            }else {
                echo "用户名不存在";
                return redirect("/login");
                die;
            }
            echo "<pre>";
            echo print_r($u);
            echo "</pre>";
        }
        //退出登录
        public function logauto()
        {
            //退出登录 清除id 和 用户名
            session::delete('user_id');
            session::delete('user_name');
            //退出成功后跳转页面
            return redirect("/login");
        }


        //个人中心
        public function center ()
        {
            $sess = session::get();
            //判断用户是否以登录
            if(empty($sess['user_id']) && empty($sess['user_name'])){
                    echo "请先登录";
                    return redirect("/login");
            }
           $user_id = Session::get('user_id');
           //查询数据库用户信息
           $list = Db::table('p_users')->field('user_name,email,mobile')->where('user_id',$user_id)->find();
           //查询用户登录记录
           $ppp = Db::table('ppp')->where('datauid',$user_id)->select();

           //foreach 处理字段  把时间戳改成 年 月 日
            foreach ($ppp as $k=>$v){
                $ppp[$k]['datatime'] = date('Y-m-d H:i:s',$v['datatime']);
            }

            //查找我的预定
            $yud = Db::table('zwei')->where('uid',$sess['user_id'])->select();
            //处理时间戳 把时间戳转化为 年 月 日
            foreach($yud as $k=>$v){
                    $yud[$k]['time'] = date("Y-m-d H:i:s",$yud[$k]['time']);
            }

           $this->assign('user_name',$list['user_name']);
           $this->assign('email',$list['email']);
           $this->assign('ppp',$ppp);

           //把我的预定模板变化赋值
           $this->assign('yud',$yud);
           return $this->fetch();
        }


        //商品列表
        public function detail ($user_id=0)
        {
            $list = Db::table('p_users')->field('user_id,user_name,reg_time,last_ip')->where('user_id',$user_id)->find();
            $this->assign('user_id',$list['user_id']);
            $this->assign('user_name',$list['user_name']);
            $this->assign('reg_time',$list['reg_time']);
            $this->assign('last_ip',$list['last_ip']);
            return $this->fetch();
        }
        //商品列表 逻辑
        public function goodsList ()
        {
            $list = Db::table('p_users')->field('user_id,user_name,email,mobile')->order('user_id')->limit(10)->select();
            $this->assign('list',$list);
            return $this->fetch();
        }



        //考试   添加
        public function book ()
        {
            return $this->fetch();
        }
        //添加逻辑
        public function bookgo()
        {
            //获取post 文本框里的值
            $book_name = $_POST['book_name'];
            $book_price = $_POST['book_price'];
            $book_num = $_POST['book_num'];
            $is_sale = $_POST['is_sale'];
            if(empty($book_name)){
                    echo "姓名不能为空";
                    die;
            }
            if(empty($book_price)){
                    echo "价格不能为空";
                    die;
            }
            if(empty($book_num)){
                    echo "数量不能为空";
                    die;
            }
            if(empty($is_sale)){
                    echo "是否上架不能为空";
                    die;
            }
            $date = [
                'book_name' => $book_name,
                'book_price' => $book_price,
                'book_num' => $book_num,
                'is_sale' => $is_sale,
            ];
            //添加到数据库
            $list = Db::table('book')->insert($date);
            if ($list){
                echo "数据添加成功";
                return redirect("book");
            }else {
                echo "数据添加失败";
            }
        }


        //列表展示
        public function goodsbook ()
        {
            //查找数据库里的数据
            $list = Db::table('book')->select();
            $this->assign('list',$list);
            return $this->fetch();
        }


        //删除数据
        public function bookdelete ()
        {
            //接收get传参  book_id
            $book_id = $_GET['book_id'];
            //查找数据库进行删除
            $list = Db::table('book')->delete($book_id);
            if($list){
                echo "删除成功";
            }else {
                echo "删除失败";
            }
        }




        //电影评分作业
           public function film ()
            {
                //session 获取id name信息
                $sess = session::get();
                //防空 如果id和name为空就为假
                if(empty($sess)){
                    echo "请先登录";   //提示登录
                    return redirect("/login");     //跳转页面
                    die;              //die掉 以下的代码不执行
                }
                //查找数据库
                $list = Db::table('movie')->field('id,movie_name')->select();
                //foreach循环 $list       因为电影评分有7条 不写foreach的话只会显示一条
                foreach ($list as $k=>$v){
                     //查找表中的某一项 并进行求和
                     $avg = ceil(Db::table('movie_score')->where('movie_id',$v['id'])->avg('score'));
                     //把求的和 给到 $list下标$k['score']中
                     $list[$k]['score'] = $avg;
                }
                //if判断是否评分成功或
                if ($list){
                    echo "评分成功";
                }else {
                    echo "评分失败";
                }
                //模板变量赋值
                $this->assign('list',$list);
                //渲染 就是在页面 显示html页面
                return $this->fetch();

            }
        //电影逻辑
           public function filmtwo ()
            {
                //获取到session
                $sess = session::get();
                $num = $_POST['num'];
//                echo "<pre>";
//                echo print_r($num);
//                echo "</pre>";
                $list = Db::table('movie')->select();
                foreach ($list as $k=>$v ){
                    $number = intval($num[$k+1]);
                    if ($number < 0){
                            $number = 0;
                    }else if($number > 100){
                            $number = 100;
                    }
                    $data = [
                        'movie_id' => $v['id'],
                        'uid'      => $sess['user_id'],
                        'score'    => $number
                    ];
                    $list =  Db::table('movie_score')->insert($data);
                }
            }

        //抽奖作业
           public function reward()
            {
                $sess = session::get();
                if(empty($sess)){
                     echo "您还未登录";
                     die;
                }
                //当前时间戳
                $now = time();
                $before = $now - 60;
                //当前时间戳
                echo "当前时间戳" . date("Y-m-d H:i:s",$now); echo "<hr>";
                //一分钟之前时间戳
                echo "一分钟之前" . date("Y-m-d H:i:s",$before); echo "<hr>";
                $nu = Db::table('prize')->where('uid',$sess['user_id'])->where('add_time', '>',$before)->count();
                if ($nu >= 3){
                    echo "抽奖次数已用完！！！";
                    die;
                }

                //生成随机数
                $num = mt_rand(1,100);
                echo $num; echo "<br>";
                //判断随机数  中奖概率

                $data = [
                    'uid' => $sess['user_id'],
                    'add_time' => time(),
                    'number'   => $num
                ];

                $nmb = Db::table('prize')->where('number',$num)->find();
                if($nmb){
                        $jjj = mt_rand(7,100);
                        echo $jjj;
                        echo "<br>";
                        echo "滚 没有奖了！！";
                }else if($num == 1){
                    echo "恭喜你中了一等奖！";
                }else if($num == 2 || $num == 3 ){
                    echo "恭喜你中了二等奖！";
                }else if ($num == 4 || $num == 5 || $num == 6){
                    echo "恭喜你中了三等奖！";
                }else{
                    echo "未中奖,再接再厉！";
                }

                $list = Db::table('prize')->insert($data);
                $this->assign('list',$list);
                return $this->fetch();
            }

            //预定
            public function goo ()
            {
                $sess = session::get();
                if(empty($sess)){
                    echo "请先登录";
                    die;
                }
                $list = Db::table('zwei')->select();
                $this->assign('list',$list);
                return $this->fetch();
            }
            //预定逻辑
            public function goolist()
            {
                $sess = session::get();
                $time = time();
                $num = $time - 86400;
                //当前时间
                echo "当前时间" . date('Y-m-d H:i:s',$time);
                echo "一天前的时间" . date('Y-m-d H:i:s',$num);
                $un = Db::table('zwei')->where('uid',$sess['user_id'])->where('time','>',$num)->count();
                if($un = 1){
                        echo $this->success("您当天预定座位已到次数,请24小时后在来！","goo");

                        die;
                }

                $goost = Db::table('zwei')->field('uid');
                $time = time();
                $sess = session::get();
                $list = Db::table('zwei')->where('number',$_POST['shuwei'])->update(['ztai'=>'已','uid'=>$sess['user_id'],'time'=>time()]);
                if($list){
                        echo $this->success('修改成功,正在为您跳转页面','goo');
                }else {
                        echo $this->success('修改失败,正在为您跳转页面','goo');
                }
            }
            public function goodate()
            {
                $sess = session::get();
                $list = Db::table('zwei')->where('number',$_POST['shuwei'])->update(['ztai'=>'未','uid'=>NULL,'time'=>NULL]);
                if($list){
                    echo $this->success('修改成功，正在为您跳转页面','/goo');
                }else {
                    echo $this->success('修改失败,正在为您跳转页面','/goo');
                }
            }

            //作业
            public function onge ()
            {
                //消费最多的前10个用户   JOIN 写法
//                $list = Db::table('p_order_info')->alias('a')
//                    ->field('b.user_id,b.user_name,b.reg_time,sum(a.goods_amount) as tble')
//                    ->join('p_users b','a.user_id=b.user_id')
//                    ->group('b.user_id')
//                    ->order('tble','desc')
//                    ->limit(10)
//                    ->select();
                //原生sql写法
//              SELECT a.user_id,a.user_name,a.reg_time,sum(b.goods_amount) as tble from p_users as a,p_order_info as b WHERE a.user_id=b.user_id
//		        GROUP BY b.user_id ORDER BY tble desc LIMIT 10;

                // 订单最多的前10个用户信息
//                $list = Db::table('p_order_info')->alias('a')
//                    ->field('b.user_id,b.user_name,b.reg_time,count(a.order_status) as tble')
//                    ->join('p_users b','a.user_id=b.user_id')
//                    ->group('b.user_id')
//                    ->order('tble','desc')
//                    ->limit(10)
//                    ->select();

                //卖的最多的前10个商品
//                $list = Db::table('p_order_info')->alias('a')
//                    ->field('b.user_id,b.user_name,count(a.user_id) as tble')
//                    ->join('p_users b','a.user_id=b.user_id')
//                    ->group('b.user_id')
//                    ->order('tble','desc')
//                    ->limit(10)
//                    ->select();
//                echo "<pre>";
//                echo print_r($list);
//                echo "</pre>";

                //订单的平均金额
//                $list = Db::table('p_order_info')->avg('goods_amount');

                //人均消费

            }




}


//public function index()
//{
//    $str = "我是session值";    // 自定义值    数组 数字  字符串  都可以
//    Session::get("one",$str);       //把$str的值  存到session里
//    $one = Session::get();   //获取session
//    dump($one);      //输出session
//    Session::delete($one);     //删除session
//    if(isset($one)){       //判断session是否存在
//            echo ""
//    }
//}