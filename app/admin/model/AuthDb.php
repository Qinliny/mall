<?php
namespace app\admin\model;


use think\Exception;

class AuthDb extends BaseDb
{
    // 角色表
    private static $roleTable = "role";

    /**
     * 添加角色
     * @param string $roleName  角色名称
     * @return bool
     */
    public static function creaeRole(string $roleName) {
        try {
            $result = self::Db(self::$roleTable)->insert([
                'role_name' =>  $roleName,
                'create_time'   =>  thisTime(),
                'update_time'   =>  thisTime()
            ]);
            return $result > 0;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 根据角色名称查询数据
     * @param string $roleName          角色名称
     * @return array|bool|\think\Model  返回角色数据
     */
    public static function findRoleByRoleName(string $roleName) {
        try {
            $result = self::Db(self::$roleTable)
                ->where('role_name', $roleName)
                ->find();
            return empty($result) ? [] : $result;
        } catch (Exception $exception) {
            return false;
        }
    }
}