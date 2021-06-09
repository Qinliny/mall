<?php
namespace app\admin\model;


use think\Exception;

class AdminsDb extends BaseDb
{
    private static $table = "admins";

    /**
     * 保存添加管理信息数据
     * @param $data 数据
     * @return bool 返回信息
     */
    public static function saveAdminsInfo($data) {
        try {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $result = self::Db(self::$table)->insert([
                'admins_name'   =>  $data['admins_name'],
                'phone'         =>  $data['phone'],
                'email'         =>  $data['email'],
                'wx_number'     =>  $data['wx_number'],
                'qq_number'     =>  $data['qq_number'],
                'native_place'  =>  $data['native_place'],
                'birthday'      =>  $data['birthday'],
                'sex'           =>  $data['sex'],
                'password'      =>  $password,
                'role_id'       =>  $data['role'],
                'create_time'   =>  thisTime(),
                'update_time'   =>  thisTime()
            ]);
            return $result > 0;
        } catch (Exception $exception) {
            return false;
        }
    }
}