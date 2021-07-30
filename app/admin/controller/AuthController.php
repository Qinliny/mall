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
        returnTables($result->total(), $result->items());
    }

    // 创建角色
    public function createRole() {
        $param = $this->request->post();
        // 验证数据
        validate(AuthValidate::class)->scene('createRole')->check($param);
        // 判断角色是否存在
        $result = AuthDb::findRoleByRoleName($param['roleName']);
        if (!empty($result)) \exception("角色名称已存在", __LINE__);
        // 保存数据
        AuthDb::creaeRole($param['roleName']);
        successAjax("创建角色成功！");
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
                \exception("请求参数异常", __LINE__);
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
        if (empty($result)) failedAjax("当前角色不存在", __LINE__);
        if (is_null($status)) failedAjax(__LINE__, "状态参数异常");
        // 修改数据
        AuthDb::updateRoleStatus($roleId, (int)$status);
        successAjax("状态修改成功！");
    }

    /**
     * 修改角色信息
     * @param $param
     */
    public function updateRoleData($param) {
        // 验证数据
        validate(AuthValidate::class)->scene('createRole')->check($param);
        $roleId = (int)$param['roleId'];
        // 查询角色信息
        $roleInfo = AuthDb::findRoleByRoleId($roleId);
        if (empty($roleInfo)) {
            failedAjax(__LINE__, 当前角色不存在);
        }

        // 判断角色是否存在
        $result = AuthDb::findRoleByRoleName($param['roleName']);
        if (!empty($result)) {
            failedAjax(__LINE__, "角色名称已存在!");
        }

        // 保存数据
        $res = AuthDb::updateRoleData($roleId, $param['roleName']);
        successAjax("角色信息修改成功！");
    }

    /**
     * 删除角色
     * @param $roleId int 角色ID
     */
    public function deleteRole() {
        $roleId = $this->request->post('roleId');
        $result = AuthDb::findRoleByRoleId((int)$roleId);
        if (empty($result)) failedAjax(__LINE__,"当前角色不存在！");
        // 进行删除
        AuthDb::deleteRoleById($roleId);
        successAjax("角色删除成功！");
    }

    /**
     * 菜单设置页面
     * @return \think\response\View
     */
    public function rule() {
        $parentMenu = AuthDb::getAllParentMenu();
        if ($parentMenu === false) {
            \exception("获取一级菜单失败", __LINE__);
        }
        return view('auth/rule', ['parentMenu'=>$parentMenu]);
    }

    /**
     * 保存创建菜单的数据
     */
    public function createRule() {
        $param = $this->request->post();
        validate(AuthValidate::class)->scene('createMenu')->check($param);
        // 如果是一级菜单则设置上级菜单为0，没有则查询这个上级菜单是否存在
        if ($param['parent_menu'] != 0) {
            $parentMenuData = AuthDb::findRuleByRuleId($param['parent_menu']);
            if ($parentMenuData === false) {
                failedAjax(__LINE__, "选择的上级菜单不存在");
            }
        }
        // 保存数据
        AuthDb::createRule($param);
        successAjax("创建菜单成功!");
    }

    /**
     * 获取菜单列表
     */
    public function getRuleList() {
        $param = $this->request->get();
        $page = isset($param['page']) && $param['page'] > 0 ? $param['page'] : 1;
        $limit = isset($param['limit']) && $param['limit'] > 0 ? $param['limit'] : 10;
        $condition = [];
        if (isset($param['childMenu'])) {
            $condition[] = ['parent_menu', '=', $param['childMenu']];
        }
        if (isset($param['parentMenu'])) {
            $condition[] = ['id', '=', $param['parentMenu']];
        }
        if (isset($param['ruleName'])) {
            $condition[] = ['menu_name', 'like', '%'.$param['ruleName'].'%'];
        }
        if (empty($condition) ) {
            $condition[] = ['parent_menu', '=', 0];
        }
        $result = AuthDb::getMenuList($page, $limit, $condition);
        returnTables($result->total(), $result->items());
    }

    /**
     * 修改菜单的信息
     */
    public function updateRule() {
        $param = $this->request->post();
        validate(AuthValidate::class)->scene('createMenu')->check($param);
        // 判断当前修改的菜单是否存在
        $result = AuthDb::findRuleByRuleId($param['ruleId']);
        if ($result === false || empty($result)) {
            failedAjax(__LINE__, "修改失败，当前菜单不存在");
        }
        // 如果是一级菜单则设置上级菜单为0，没有则查询这个上级菜单是否存在
        if ($param['parent_menu'] != 0) {
            $parentMenuData = AuthDb::findRuleByRuleId($param['parent_menu']);
            if ($parentMenuData === false || empty($parentMenuData)) {
                failedAjax(__LINE__, "选择的上级菜单不存在");
            }
        }
        $updateData = [
            'menu_name'     =>  $param['menu_name'],
            'parent_menu'   =>  $param['parent_menu'],
            'menu_adds'     =>  $param['menu_adds'],
            'menu_icon'     =>  $param['menu_icon'],
            'sort'          =>  $param['sort'],
            'update_time'   =>  thisTime()
        ];
        // 修改数据
        AuthDb::updateMenu($param['ruleId'], $updateData);
        successAjax("修改菜单数据成功！");
    }

    /**
     * 修改状态信息
     */
    public function updateRuleStatus() {
        $param = $this->request->post();
        $ruleStatus = isset($param['status']) && in_array($param['status'], [1, 0]) ? $param['status'] : null;
        $ruleId = (int)$param['ruleId'];
        $res = AuthDb::findRuleByRuleId($ruleId);
        if (empty($res)) failedAjax(__LINE__,"当前菜单不存在！");
        if (is_null($ruleStatus)) failedAjax(__LINE__, "状态参数异常");
        // 修改数据
        $res = AuthDb::updateMenu($ruleId, ['status'=>$ruleStatus]);
        successAjax("状态修改成功！");
    }

    /**
     * 删除菜单
     */
    public function deleteRule() {
        $ruleId = $this->request->post('ruleId');
        // 查询是否存在该菜单
        $res = AuthDb::findRuleByRuleId($ruleId);
        if ($res === false || empty($res)) {
            failedAjax(__LINE__, "菜单不存在");
        }
        // 判断是否是一级菜单，如果是一级菜单，则需要将所有的菜单都进行删除
        $condition = [];
        if ($res['parent_menu'] != 0) {
            $condition[] = ['id', '=', $ruleId];
        } else {
            // 查询所有的下级菜单
            $childMenu = AuthDb::getChildMenu($ruleId);
            $childMenuId = array_column($childMenu->toArray(), 'id');
            array_push($childMenuId, $ruleId);
            $condition[] = [
                'id', 'in', $childMenuId
            ];
        }
        $result = AuthDb::deleteMenu($condition);
        successAjax("菜单删除成功！");
    }

    public function setRule() {
        $roleId = $this->request->get('roleId');
        // 判断角色是否存在
        $result = AuthDb::findRoleByRoleId((int)$roleId);
        if (empty($result)) \exception("角色不存在",__LINE__);
        // 获取菜单数据
        $menuList = AuthDb::getMenuList(1, 100);
        $menu = getChildMenu($menuList->items());
        $getTreeList = [];
        foreach ($menu as $key => $value) {
            $data = [
                'title' =>  $value['menu_name'],
                'id'    =>  $value['id'],
                'spread'=>  true,
            ];
            if (isset($value['childMenu'])) {
                foreach ($value['childMenu'] as $child) {
                    $data['children'][] = [
                        'title' => $child['menu_name'],
                        'id'    =>  $child['id']
                    ];
                }
            }
            $getTreeList[] = $data;
        }
        return view('auth/setRule', ['treeList'=>json_encode($getTreeList)]);
    }
}