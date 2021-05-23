<?php
namespace app\admin\controller;

use app\admin\validate\GoodsCategoryValidate;
/**
 * 商品分类操作类
 * Class GoodsCategoryController
 * @package app\admin\controller
 */
class GoodsCategoryController extends BaseController
{
    /**
     * 商品分类主页
     * @return \think\response\View
     */
    public function category() {
        return view('goods_category/index');
    }

    /**
     * 添加商品分类
     * @return \think\response\View
     */
    public function createCategory() {
        return view('goods_category/create');
    }

    public function saveCreateData() {
        $param = $this->request->post();
        try {
            // 验证数据
            validate(GoodsCategoryValidate::class)->check($param);
        } catch (ValidateException $e) {
            
        }
        // 判断分类是否已经存在
        // 保存分类数据
    }
}