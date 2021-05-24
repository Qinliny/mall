<?php
namespace app\admin\model;

use think\facade\Db;

class BaseDb
{
    // 设置请求
    public static function Db($table) {
        return Db::connect('admin')->name($table);
    }
}