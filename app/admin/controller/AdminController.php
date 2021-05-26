<?php
namespace app\admin\controller;

/**
 * 管理员管理控制器
 * Class AdminController
 * @package app\admin\controller
 */
class AdminController extends BaseController
{
    public function admins() {
        return view('admin/admins');
    }
}