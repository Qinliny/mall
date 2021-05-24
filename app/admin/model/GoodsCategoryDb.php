<?php
namespace app\admin\model;

use think\Exception;
use think\Db;
/**
 * 商品分类数据交互类
 * Class GoodsCategoryDb
 * @package app\admin\model
 */
class GoodsCategoryDb extends BaseDb
{
    // 表名
    private static $table = "qinly_goods_category";

    /**
     * 返回商品分类列表的数据
     * @return bool|\think\Collection
     */
    public static function getGoodsCategoryList($page, $limit = 10) {
        try {
            $result = self::Db(self::$table)->order('id', 'desc')->paginate(['list_rows'=>$limit, 'page'=>$page]);
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
}