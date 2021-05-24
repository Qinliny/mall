<?php
namespace app\admin\controller;

use app\admin\validate\GoodsCategoryValidate;
use app\admin\model\GoodsCategoryDb;
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
        // 获取分类数据
        $result = GoodsCategoryDb::getFirstGoodsCategoryList();
        if ($result === false) {
            abort(__LINE__, '获取分类数据失败！');
        }
        return view('goods_category/create', ['list'=>$result]);
    }


    public function saveCreateData() {
        $param = $this->request->post();
        // 验证数据
        validate(GoodsCategoryValidate::class)->check($param);
        // 判断分类是否已经存在
        // 保存分类数据
    }
}