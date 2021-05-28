<?php
namespace app\admin\controller;

use app\admin\model\AuthDb;
use think\Exception;
use think\exception\ValidateException;
use app\admin\validate\AuthValidate;

/**
 * 角色-权限管理的控制类
 * Class AuthController
 * @package app\admin\controller
 */
class AuthController extends BaseController
{
    /**
     * 角色管理页面
     * @return \think\response\View
     */
    public function role() {
        return view('auth/role');
    }

    /**
     * 获取角色列表
     */
    public function getRoleList(){
        $param = $this->request->get();
        $condition = [];
        $page = isset($param['page']) && $param['page'] > 0 ? (int)$param['page'] : 1;
        $limit = isset($param['limit']) ? (int)$param['limit'] : 10;
        if (isset($param['role_name'])) {
            $condition[] = [
                'role_name', 'like', '%' . $param['role_name'] . '%'
            ];
        }
        $result = AuthDb::getRoleList($page, $limit, $condition);
        if($result === false) abort(__LINE__, "查询角色列表失败");
        returnTables($result->total(), $result->items());
    }

    /**
     * 创建角色
     * @param   $roleName   string
     */
    public function createRole() {
        $param = $this->request->post();
        try {
            // 验证数据
            validate(AuthValidate::class)->scene('createRole')->check($param);
            // 判断角色是否存在
            $result = AuthDb::findRoleByRoleName($param['roleName']);
            if ($result === false) throw new Exception("查询角色数据出现异常");
            if (!empty($result)) failedAjax(__LINE__, "角色名称已存在!");
            // 保存数据
            $res = AuthDb::creaeRole($param['roleName']);
            if ($res === false) throw new Exception("创建角色失败！");
            successAjax("创建角色成功！");
        } catch (ValidateException $exception) {
            failedAjax(__LINE__, $exception->getError());
        } catch (Exception $exception) {
            abort(__LINE__, $exception->getMessage());
        }
    }

    /**
     * 统一修改接口
     * @param $type string 对应的修复入口
     */
    public function updateRole() {
        $param = $this->request->post();
        $type = isset($param['type']) ? $param['type'] : null;
        switch ($type) {
            case "updateStatus":
                $this->updateRoleStatus($param);
                break;
            case "updateRoleName":
                $this->updateRoleData($param);
                break;
            default:
                failedAjax(__LINE__, "请求参数异常！");
                break;
        }
    }

    /**
     * 修改角色的状态信息
     * @param $param    请求参数
     */
    public function updateRoleStatus($param) {
        $status = isset($param['status']) && in_array($param['status'], [1, 0]) ? $param['status'] : null;
        $roleId = (int)$param['roleId'];
        $result = AuthDb::findRoleByRoleId($roleId);
        if ($result === false) abort("查询数据出现异常！");
        if (empty($result)) failedAjax(__LINE__,"当前角色不存在！");
        if (is_null($status)) failedAjax(__LINE__, "状态参数异常");
        // 修改数据
        $res = AuthDb::updateRoleStatus($roleId, (int)$status);
        if ($res === false) {
            failedAjax(__LINE__, "状态修改失败！");
        }
        successAjax("状态修改成功！");
    }

    /**
     * 修改角色信息
     * @param $param
     */
    public function updateRoleData($param) {
        try {
            // 验证数据
            validate(AuthValidate::class)->scene('createRole')->check($param);
            $roleId = (int)$param['roleId'];
            // 查询角色信息
            $roleInfo = AuthDb::findRoleByRoleId($roleId);
            if ($roleInfo === false) {
                throw new Exception("查询角色数据出现异常");
            }
            if (empty($roleInfo)) {
                throw new Exception("当前角色不存在");
            }

            // 判断角色是否存在
            $result = AuthDb::findRoleByRoleName($param['roleName']);
            if ($result === false) {
                throw new Exception("查询角色数据出现异常");
            }
            if (!empty($result)) {
                failedAjax(__LINE__, "角色名称已存在!");
            }

            // 保存数据
            $res = AuthDb::updateRoleData($roleId, $param['roleName']);
            if ($res === false) {
                throw new Exception("角色信息修改失败！");
            }
            successAjax("角色信息修改成功！");
        } catch (ValidateException $exception) {
            failedAjax(__LINE__, $exception->getError());
        } catch (Exception $exception) {
            abort(__LINE__, $exception->getMessage());
        }
    }

    /**
     * 删除角色
     * @param $roleId int 角色ID
     */
    public function deleteRole() {
        $roleId = $this->request->post('roleId');
        $result = AuthDb::findRoleByRoleId((int)$roleId);
        if ($result === false) abort("查询数据出现异常！");
        if (empty($result)) failedAjax(__LINE__,"当前角色不存在！");
        // 进行删除
        $res = AuthDb::deleteRoleById($roleId);
        if ($res === false) {
            failedAjax(__LINE__, "角色删除失败！");
        }
        successAjax("角色删除成功！");
    }

    /**
     * 菜单设置页面
     * @return \think\response\View
     */
    public function rule() {
        $parentMenu = AuthDb::getAllParentMenu();
        if ($parentMenu === false) {
            abort(__LINE__, "获取一级菜单失败！");
        }
        return view('auth/rule', ['parentMenu'=>$parentMenu]);
    }

    /**
     * 保存创建菜单的数据
     */
    public function createRule() {
        $param = $this->request->post();
        try {
            validate(AuthValidate::class)->scene('createMenu')->check($param);
            // 如果是一级菜单则设置上级菜单为0，没有则查询这个上级菜单是否存在
            if ($param['parent_menu'] != 0) {
                $parentMenuData = AuthDb::findRuleByRuleId($param['parent_menu']);
                if ($parentMenuData === false) {
                    throw new Exception("选择的上级菜单不存在！");
                }
            }
            // 保存数据
            $res = AuthDb::createRule($param);
            if ($res === false) {
                throw new Exception("创建菜单失败！");
            }
            successAjax("创建菜单成功!");
        } catch (ValidateException $exception) {
            // 返回校验的错误信息
            return failedAjax(__LINE__, $exception->getError());
        } catch (Exception $exception) {
            return failedAjax(__LINE__, $exception->getMessage());
        }
    }
}