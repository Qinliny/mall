<?php
namespace app\admin\controller;

use app\admin\model\AdminsDb;
use app\admin\model\AuthDb;
use app\admin\validate\AdminsValidate;
use think\Exception;
use think\exception\ValidateException;

/**
 * 管理员管理控制器
 * Class AdminController
 * @package app\admin\controller
 */
class AdminController extends BaseController
{
    /**
     * 管理员管理页面
     * @return \think\response\View
     */
    public function admins() {
        $roleList = AuthDb::getRoleList(1, 1000, []);
        if ($roleList === false) {
            exception("获取角色信息数据失败！", __LINE__);
        }
        return view('admin/admins', ['role'=>$roleList->items()]);
    }

    /**
     * 创建管理员页面
     * @return \think\response\View
     */
    public function createAdmins() {
        // 获取角色列表
        $roleList = AuthDb::getRoleList(1, 100, ['status'=>0]);
        return view('admin/create', ['roleList'=>$roleList->items()]);
    }

    // 添加管理员
    public function saveAdmins() {
        $param = request()->post();
        // 校验请求参数
        validate(AdminsValidate::class)->scene('create')->check($param);
        // 判断选择的角色是否存在
        $checkRole = AuthDb::findRoleByRoleId($param['role']);
        if (empty($checkRole)) {
            exception("选择的角色不存在！", __LINE__);
        }
        AdminsDb::saveAdminsInfo($param);
        successAjax("管理员添加成功！");
    }

    // 获取管理员信息列表
    public function getAdminsList() {
        $param = $this->request->param();
        $page = isset($param['page']) && $param['page'] > 0 ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 10;
        // 添加查询条件
        $where = [];
        // 手机号码
        if (isset($param['param']['phone']) && !empty($param['param']['phone'])) {
            $where[] = ['a.phone', '=', $param['param']['phone']];
        }
        // 电子邮箱
        if (isset($param['param']['email']) && !empty($param['param']['email'])) {
            $where[] = ['a.email', '=', $param['param']['email']];
        }
        // 管理员名称
        if (isset($param['param']['name']) && !empty($param['param']['name'])) {
            $where[] = ['a.admins_name', '=', $param['param']['name']];
        }
        // 角色
        if (isset($param['param']['role']) && !empty($param['param']['role'])) {
            $where[] = ['a.role_id', '=', $param['param']['role']];
        }
        $result = AdminsDb::getAdminsList($page, $limit, $where);
        if ($result === false) {
            \exception("获取管理员列表信息失败", __LINE__);
        }
        returnTables($result->total(), $result->items());
    }

}