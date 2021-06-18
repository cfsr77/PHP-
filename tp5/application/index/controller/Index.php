<?php
namespace app\index\controller;

use think\Db;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    //登录
    public function log ()
    {
        echo __METHOD__;
    }

    //注册
    public function reg ()
    {
        echo "注册逻辑";
    }
    //链接数据库 查找一条
    public function shu1 ()
    {
        $ku = Db::table('p_goods')->where('goods_id=217')->find();
        echo "<pre>";
        echo print_r($ku);
        echo "</pre>";
    }
    //链接数据库 列表展示
    public function goodsList ()
    {
        //转原sql语句   select goods_id,goods_name,_shop_price from limit 10;
        $list = Db::table('p_goods')->field('goods_id,goods_name,shop_price')->limit(10)->select();
        echo "<pre>";echo print_r($list);echo "</pre>";
    }
    //链接数据库 所有列表展示
    public function gooList ()
    {
        $list = Db::table('p_users')->select();
        echo "<pre>";
        echo print_r($list);
        echo "</pre>";
    }

    public function Lst ()
    {
        //查询年龄大于20的学生信息
//        $list = Db::table('stub')->where('sex', '>', 20)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";

        //查询所有数据print_r 打印出来
//        $list = Db::table('stub')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";

        //查询年龄小于18的学生信息（显示10条 倒序排序）
//        $list = Db::table('stub')->where('sex','<',18)->limit(10)->order('sex','desc')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询性别为女的学生信息
//        $list = Db::table('stub')->where('age','=',0)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询男同学的信息
//        $list = Db::table('stub')->where('age','=',1)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询综合积分在150分以下的同学信息
//        $list = Db::table('stub')->where('score','>',100)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
          //查询综合积分小于59 学生的姓名 年龄     未完成
//        $list = Db::table('stub')->where('score','<',59)->field('stu_name,sex')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询命令在18到25之间的学生信息
//        $list = Db::table('stub')->where('sex','<',25,'and','>',15)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询女同学 年龄小于20 的学生的姓名 年龄
//        $list = Db::table('stub')->where('sex','<','20')->where('age','=','0')->field('stu_name,sex')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询id为5的一条数据
//        $list = Db::table('stub')->where('id','=','5')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询综合积分小于150的、
//        $list = Db::table('stub')->where('score','<','100')->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";
        //查询id为5-10之间同学的综合积分
//        $list = Db::table('stub')->order('id')->limit(5,5)->select();
//        echo "<pre>";
//        echo print_r($list);
//        echo "</pre>";


    }
}
