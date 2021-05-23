<?php
namespace app\admin\controller;

class IndexController extends BaseController
{
    /**
     * 应用主入口
     * @return \think\response\View
     */
    public function index() {
        return view('index/index');
    }

    public function home() {
        return view('index/home');
    }
}