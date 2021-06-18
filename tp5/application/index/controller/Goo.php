<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\facade\Session;
class Goo extends Controller
{
    public function goo ()
    {
        return $this->fetch();
    }
    public function goolist()
    {

    }
}