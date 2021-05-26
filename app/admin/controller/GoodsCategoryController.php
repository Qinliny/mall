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
            // 判断是否已存在
            $categoryInfo = GoodsCategoryDb::getGoodsCategoryDataByName($param['category_name']);

            if ($categoryInfo === false) throw new Exception("获取分类信息失败！", __LINE__);

            if (!empty($categoryInfo)) throw new Exception("分类信息已存在！", __LINE__);

            // 保存分类数据
            $res = GoodsCategoryDb::createData($param);
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

    /**
     * 获取分类数据
     * @param   $page        int 分页
     * @param   $limit       int 数据条数
     * @param   $parent_id   int 父级分类ID
     * @param   $category_name   string  查询分类名称
     */
    public function getGoodsCategoryList() {
        $param = $this->request->get();
        $page = isset($param['page']) && $param['page'] > 0 ? $param['page'] : 1;
        $limit = isset($param['limit']) && $param['limit'] > 0 ? $param['limit'] : 10;
        $parentId = isset($param['parent_id']) ? $param['parent_id'] : 0;
        $condition = [];
        if (isset($param['category_name'])) {
            $condition[] = ['category_name', 'like', '%' . $param['category_name'] . '%'];
        } else {
            $condition[] = ['parent_id', '=', $parentId];
        }

        $result = GoodsCategoryDb::getGoodsCategoryList($page, $limit, $condition);
        if($result === false) {
            abort(__LINE__, '获取分类列表数据失败！');
        }
        returnTables($result->total(), $result->items());
    }

    /**
     * 修改分类状态
     * @param   $id      分类的ID
     * @param   $status  修改的状态
     */
    public function updateGoodsCategoryStatus() {
        // 获取数据的ID
        $id = $this->request->post('id');
        // 获取修改的状态
        $status = $this->request->post('status');
        $status = in_array((int)$status, [0, 1]) ? $status : 0;
        if (empty($id)) failedAjax(__LINE__, "参数异常");
        // 判断当前数据是否存在
        $info = GoodsCategoryDb::getGoodsCategoryDataById($id);
        if ($info === false) failedAjax(__LINE__, "获取分类数据异常！");
        if (empty($info)) failedAjax(__LINE__, "分类信息不存在！");

        // 判断是否是一级状态，如果是一级状态则修改一级分类的状态以及下面所有的二级的状态，反之只修改当前状态
        if ($info['parent_id'] == 0) {
            // 状态关闭
            if ($status == 1) {
                // 获取所有的二级分类信息
                $childData = GoodsCategoryDb::getGoodsCategoryChildDataById($info['id']);
                $childDataId = array_column($childData->toArray(), 'id');
                array_push($childDataId, $info['id']);
                $condition = [
                    ['id', 'in', $childDataId]
                ];
            } else {
                $condition = [
                    ['id', '=', $id]
                ];
            }
        } else {
            if ($status == 1) {
                $condition = [
                    ['id', '=', $id]
                ];
            } else {
                $condition = [
                    ['id', 'in', [$info['parent_id'], $id]]
                ];
            }
        }
        $res = GoodsCategoryDb::updateGoodsCategoryData($condition, ['status'=>$status,'update_time'=>thisTime()]);
        if ($res === false) {
            failedAjax(__LINE__, "状态更新失败！");
        }
        successAjax("状态更新成功！");
    }

    /**
     * 删除分类
     * @param   $id  int   分类id
     */
    public function deleteGoodsCategory() {
        $id = $this->request->post('id');
        if(empty($id)) failedAjax("参数异常！");

        // 判断当前数据是否存在
        $info = GoodsCategoryDb::getGoodsCategoryDataById($id);
        if ($info === false) failedAjax(__LINE__, "获取分类数据异常！");
        if (empty($info)) failedAjax(__LINE__, "分类信息不存在！");

        if ($info['parent_id'] == 0) {
            // 以及分类需要将下面所有二级的都进行删除
            // 获取所有的二级分类信息
            $childData = GoodsCategoryDb::getGoodsCategoryChildDataById($info['id']);
            $childDataId = array_column($childData->toArray(), 'id');
            array_push($childDataId, $info['id']);
            $condition = [
                ['id', 'in', $childDataId]
            ];
        } else {
            $condition = [
                ['id', '=', $id]
            ];
        }

        $result = GoodsCategoryDb::deleteGoodsCategory($condition);
        if ($result === false) {
            failedAjax(__LINE__, "删除失败！");
        }
        successAjax("删除成功！");
    }
}