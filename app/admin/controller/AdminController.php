<?php
namespace app\admin\controller;

use app\admin\model\AuthDb;

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
        return view('admin/admins');
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

    public function saveAdmins() {
        $param = $this->request->post();
    }
}