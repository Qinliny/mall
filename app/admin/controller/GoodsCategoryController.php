<?php
namespace app\admin\controller;

use app\admin\validate\GoodsCategoryValidate;
use app\admin\model\GoodsCategoryDb;
use think\Exception;
use think\exception\ValidateException;

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

    /**
     * 保存商品分类的信息
     */
    public function saveCreateData() {
        $param = $this->request->post();
        try {
            // 验证数据
            validate(GoodsCategoryValidate::class)->check($param);
            // 保存分类数据
            $res = GoodsCategorWyDb::createData($param);
            if ($res) {
                successAjax("商品分类信息创建成功！");
            }
            throw new Exception("商品分类信息创建失败！", __LINE__);
        } catch (ValidateException $exception) {
            // 返回错误的验证信息
            failedAjax(__LINE__, $exception->getError());
        } catch (Exception $exception) {
            failedAjax($exception->getCode(), $exception->getMessage());
        }
    }
}