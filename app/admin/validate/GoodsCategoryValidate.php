<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 验证商品分类的验证器
 * Class GoodsCategoryValidate
 * @package app\admin\validate
 */
class GoodsCategoryValidate extends Validate
{
    protected $rule = [
        'category_name'     =>  'require|length:1,6',
        'category_parent'   =>  'require|integer',
        'sort'              =>  'require|between:0,100'
    ];

    protected $message = [
        'category_name.require'     =>  '请输入商品分类名称',
        'category_name.length'      =>  '商品分类名称的长度只能为1-6个字符',
        'category_parent.require'   =>  '请选择商品分类',
        'category_parent.integer'   =>  '请选择正确的商品分类',
        'sort.require'              =>  '请输入商品分类的排序',
        'sort.between'              =>  '商品分类的排序值只能在0-100之间'
    ];
}