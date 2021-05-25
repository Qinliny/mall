<?php
namespace app\admin\model;

use think\Exception;
/**
 * 商品分类数据交互类
 * Class GoodsCategoryDb
 * @package app\admin\model
 */
class GoodsCategoryDb extends BaseDb
{
    // 表名
    private static $table = "goods_category";

    /**
     * 返回商品分类列表的数据
     * @return bool|\think\Collection
     */
    public static function getGoodsCategoryList(int $page, int $limit = 10) {
        try {
            $result = self::Db(self::$table)
                ->field('id, category_name, parent_id, sort, status, create_time')
                ->order('id', 'desc')
                ->paginate(['list_rows'=>$limit, 'page'=>$page])
                ->each(function($item, $key){
                    $item['level'] = $item['parent_id'] == 0 ? "一级分类" : "二级分类";
                    return $item;
                });
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 获取所有的一级商品分类数据
     * @return bool|\think\Collection
     */
    public static function getFirstGoodsCategoryList() {
        try {
            $result = self::Db(self::$table)->where('parent_id', 0)->order('id', 'desc')->select();
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 根据ID获取商品分类数据
     * @param int $id
     * @return array|bool|\think\Model|null
     */
    public static function getGoodsCategoryDataById(int $id) {
        try {
            $result = self::Db(self::$table)->where('id', $id)->find();
            return $result;
        } catch (Exception $exception) {
            return false;
        }
    }


    public static function getGoodsCategoryChildDataById(int $id) {

    }

    /**
     * 创建分类数据
     * @param array $data
     * @return bool
     */
    public static function createData(array $data) : bool {
        try {
            $insertData = [
                'category_name' =>  $data['category_name'],
                'parent_id'     =>  $data['category_parent'],
                'sort'          =>  $data['sort'],
                'create_time'   =>  thisTime(),
                'update_time'   =>  thisTime()
            ];
            $res = self::Db(self::$table)->insert($insertData);
            return $res > 0;
        } catch (Exception $exception) {
            dd($exception);
            return false;
        }
    }

    /**
     * 根据分类名称获取分类信息
     * @param string $categoryName  分类名称
     * @return array|bool|\think\Model|null
     */
    public static function getGoodsCategoryDataByName(string $categoryName) {
        try {
            return self::Db(self::$table)
                    ->where('category_name', $categoryName)
                    ->find();
        } catch (Exception $exception) {
            return false;
        }
    }
}