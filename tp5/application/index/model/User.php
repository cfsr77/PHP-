<?php
    namespace app\index\model;
    use think\Model;

    class User extends Model
    {
        //指定当前模型使用的表
        protected $table = "p_users";
        //指定表的主键id
        protected $pk = "user_id";
    }
