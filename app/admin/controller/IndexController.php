<?php
namespace app\admin\controller;

/**
 * 主应用控制器
 * Class IndexController
 * @package app\admin\controller
 */
class IndexController extends BaseController
{
    /**
     * 应用主入口
     * @return \think\response\View
     */
    public function index() {
        return view('index/index');
    }

    /**
     * 主页
     * @return \think\response\View
     */
    public function home() {
        return view('index/home');
    }


}