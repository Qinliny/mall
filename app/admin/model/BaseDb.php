<?php
namespace app\admin\model;

use think\facade\Db;

class BaseDb
{
    public static function Db($table) {
        return Db::connect('admin')->table($table);
    }
}