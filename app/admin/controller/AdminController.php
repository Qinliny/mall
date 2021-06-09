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
        try {
            // 校验请求参数
            validate(AdminsValidate::class)->scene('create')->check($param);
            // 判断选择的角色是否存在
            $checkRole = AuthDb::findRoleByRoleId($param['role']);
            if ($checkRole === false || empty($checkRole)) {
                throw new Exception("选择的角色不存在！", __LINE__);
            }
            $result = AdminsDb::saveAdminsInfo($param);
            if ($result === false) {
                throw new Exception("添加管理员信息失败！", __LINE__);
            }
            successAjax("管理员添加成功！");
        } catch (ValidateException $exception) {
            failedAjax(__LINE__, $exception->getError());
        } catch (Exception $exception) {
            failedAjax($exception->getCode(), $exception->getMessage());
        }
    }
}