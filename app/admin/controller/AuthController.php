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
    public function role() {
        return view('auth/role');
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


    public function updateRole() {
        $param = $this->request->post();
        $type = isset($param['type']) ? $param['type'] : null;
        switch ($type) {
            case "updateStatus":
                $this->updateRoleStatus($param);
                break;
            case "updateRoleName":
                break;
            default:
                failedAjax(__LINE__, "请求参数异常！");
        }
    }

    public function updateRoleStatus($param) {

    }
}