<?php

namespace app\index\controller;
use think\Db;

class Goods
{
        //往数据库添加多条信息
        public function two (){
                $data = [
                    ['stu_name'=>'list','sex'=>'19','age'=>'0','score'=>'76'],
                    ['stu_name'=>'list2','sex'=>'19','age'=>'1','score'=>'56'],
                    ['stu_name'=>'list3','sex'=>'23','age'=>'0','score'=>'86'],
                    ['stu_name'=>'list4','sex'=>'39','age'=>'1','score'=>'36']
                ];
                $num = Db::name('stub')->insertAll($data);
                //获取sql 语句
                echo "获取sql语句" . Db::getlastsql();
        }

        //往数据库添加一条信息
        public function one (){
                $date = [
                    'stu_name'  => '哈哈哈',
                    'sex'       => 17,
                    'age'       => 1,
                    'score'     => 99
                ];
                $num = Db::name('stub')->insert($date);
                echo "获取sql语句" . Db::getLastsql();
            }

        //往数据库添加100条信息 随机生成 随机数
        public function three (){
            for ($i=0;$i<100;$i++) {
                //生成随机字符串  姓名
                $name = $this->sj();
                //年龄  mt_rand
                $sex = mt_rand(16, 35);
                //性别  mt_rand
                $age = mt_rand(0, 1);
                //生成随机成绩 20-100之间随机
                $score = mt_rand(20, 100);
                //往数据库里添加 上面生成的随机  //姓名 年龄 性别 成绩
                $date = [
                    'stu_name' => $name,    //姓名
                    'sex' => $sex,     //年龄
                    'age' => $age,     //性别
                    'score' => $score, //成绩
                ];
                //添加到数据库里   stub        insert 添加
                Db::name('stub')->insert($date);
            }
        }

        //定义一个函数        $eee = 6  是给到for循环里的
        public function sj ($eee = 6){
            //随机生成一些字母
            $str = 'ABCDFGHJKLOUIYREabcdefghigklmn';
            //定义一个空的字符串
            $res = "";
            //for循环 让字符串的个数为$eee = 6
            for ($i=0;$i<$eee;$i++){
                //mt_rand 随机数让他 在$str 个数中0-29 之间随便获取
                $num = mt_rand(0,29);
                //可以以数组形式  索引访问$str里的内容  把访问到的内容给到$res里面
                $res .=$str[$num];
            }
            //返回值
            return $res;
        }


        public function to ($name = 'ta2102php'){
            return 'two,' . $name;
        }

        //视图 用户注册
        public function shit(){
            echo '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Title</title>
                    </head>
                    <body>
                    <h1>注册页面！</h1>
                    <form action="注册.php" method="post">
                        <input type="text" name="user_name" placeholder="姓名"><br>
                        <input type="text" name="user_tel" placeholder="手机号"><br>
                        <input type="text" name="user_email" placeholder="邮箱"><br>
                        <input type="text" name="user_m1" placeholder="密码"><br>
                        <input type="text" name="user_m2" placeholder="确认密码"><br>
                        <input type="submit">
                    </form>
                    </body>
                    </html>';
        }
}