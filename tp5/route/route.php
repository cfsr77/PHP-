<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
//当用户访问xxx.com/hello/   xxx
Route::get('hello/:name', 'index/hello');
//用户登录
Route::get('log','index/log');
//用户注册
Route::get('reg', 'index/reg');
//链接数据库  查找一条
Route::get('p_goods/shu1','index/shu1');
//链接数据库 查找多条
Route::get('goods/list','index/goodsList');
//链接数据库 所有列表展示
Route::get('goo/list','index/gooList');
//查找数据
Route::get('goo/ist','index/Lst');


////往数据库添加一条信息
Route::get('one','Goods/one');
//往数据库添加多条信息
Route::get('two','Goods/two');
//往数据库添加100条信息 随机生成 随机数
Route::get('three','Goods/three');
//视图
Route::get('shit','Goods/shit');
//
Route::get('to/:name','Goods/two');




//用户注册
Route::get('shireg','user/reg');
Route::post('shireg','user/gg');
//登录页面
Route::get('login','user/log');
Route::post('login','user/dl');
//个人中心
Route::get('center','user/center');
//商品列表
Route::get('user/:user_id','user/detail');
Route::get('goodslist','user/goodslist');
//退出登录
Route::get('logauto','user/logauto');
//考试
Route::get('book','user/book');
Route::post('book','user/bookgo');
//商品列表
Route::get('goodsbook','user/goodsbook');
//数据删除
Route::get('bookdelete','user/bookdelete');

//电影评分作业
Route::get('film','user/film');
Route::post('filmtwo','user/filmtwo');


//抽奖作业
Route::get('reward','user/reward');



//预定座位座位
Route::get('goo','user/goo');
Route::post('goolist','user/goolist');
Route::post('goodate','user/goodate');

//查找小作业
Route::get('onge','user/onge');

//模型 获取信息
Route::get('test1','user/test1');
//模型 添加信息
Route::get('test2','user/test2');

Route::get('test3','user/test3');
Route::post('form1','user/form1');
return [

];
