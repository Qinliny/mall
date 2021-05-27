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

    /**
     * 获取数据
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @return \think\Paginator
     */
    public static function getRoleList(int $page = 1, int $limit = 10, array $condition) {
        try {
            $result = self::Db(self::$roleTable)->where($condition)
                        ->paginate(['list_rows'=>$limit, 'page'=>$page]);
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 根据角色ID查询角色信息
     * @param int $roleId
     * @return array|false|\think\Model|null
     */
    public static function findRoleByRoleId(int $roleId) {
        try {
            return self::Db(self::$roleTable)->where('id', $roleId)->find();
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 根据角色ID修改角色的状态信息
     * @param int $roleId
     * @param int $status
     * @return false
     */
    public static function updateRoleStatus(int $roleId, int $status) {
        try {
            self::Db(self::$roleTable)->where('id', $roleId)->update([
                'status'        =>  $status,
                'update_time'   =>  thisTime()
            ]);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 根据角色ID修改角色的名称
     * @param int $roleId
     * @param string $roleName
     * @return false
     */
    public static function updateRoleData(int $roleId, string $roleName) {
        try {
            self::Db(self::$roleTable)->where('id', $roleId)->update([
                'role_name'     =>  $roleName,
                'update_time'   =>  thisTime()
            ]);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 删除角色
     * @param $roleId   角色ID
     * @return bool
     */
    public static function deleteRoleById($roleId) {
        try {
            $res = self::Db(self::$roleTable)->where('id', $roleId)->delete();
            return $res > 0;
        } catch (Exception $exception) {
            return false;
        }
    }
}