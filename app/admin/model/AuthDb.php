<?php
namespace app\admin\model;


use think\Exception;

class AuthDb extends BaseDb
{
    // 角色表
    private static $roleTable = "role";
    // 菜单权限表
    private static $ruleTable = "rule";
    // 角色权限表
    private static $roleAndRuleTable = "role_rule";

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

    /**
     * 根据ID查询权限菜单信息
     * @param $ruleId
     * @return bool
     */
    public static function findRuleByRuleId($ruleId) {
        try {
            $result = self::Db(self::$ruleTable)->where('id', $ruleId)->find();
            return !empty($result);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 保存菜单创建的数据
     * @param $data
     * @return bool
     */
    public static function createRule($data) {
        try {
            $result = self::Db(self::$ruleTable)->insert([
                'menu_name'     =>  $data['menu_name'],
                'parent_menu'   =>  $data['parent_menu'],
                'menu_adds'     =>  $data['menu_adds'],
                'menu_icon'     =>  $data['menu_icon'],
                'sort'          =>  $data['sort'],
                'create_time'   =>  thisTime(),
                'update_time'   =>  thisTime()
            ]);
            return $result > 0;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 获取所有的一级菜单
     * @return false|\think\Collection
     */
    public static function getAllParentMenu() {
        try {
            $result = self::Db(self::$ruleTable)->where('parent_menu', 0)->select();
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }

    public static function getMenuList($page, $limit = 10, $condition = []) {
        try {
            $result = self::Db(self::$ruleTable)
                ->paginate(['list_rows'=>$limit, 'page'=>$page])
                ->each(function($item){
                    if ($item['parent_menu'] == 0) {
                        $item['level'] = "一级菜单";
                    } else {
                        $item['level'] = "二级菜单";
                    }
                    return $item;
                });
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }
}