<?php
namespace app\admin\controller;
/**
 * 商品列表页的控制器
 * Class GoodsController
 * @package app\admin\controller
 */
class GoodsController extends BaseController
{
    /**
     * 商品页列表
     * @return \think\response\View
     */
    public function goods() {
        return view('goods/goods');
    }
}