<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 权限控制验证器
 * Class AuthValidate
 * @package app\admin\validate
 */
class AuthValidate extends Validate
{
    protected $rule = [
        'roleId'    =>  'require|',
        'roleName'  =>  'require|length:1,10',

        'menu_name'     =>  'require|length:1,10',
        'parent_menu'   =>  'integer',
        'menu_adds'     =>  'max:100',
        'menu_icon'     =>  'max:50',
        'sort'          =>  'require|between:0,100'
    ];

    protected $message = [
        'roleName.require'  =>  '角色名称必须填写！',
        'roleName.length'   =>  '角色名称长度不能超过10个字符！',

        'menu_name.require' =>  '请填写菜单名称',
        'menu_name.length'  =>  '菜单名称长度最长为10个字符！',
        'parent_menu.integer'   =>  '请选择正确上级菜单！',
        'menu_adds.max'         =>  '菜单地址长度不能超过100个字符！',
        'menu_icon.max'         =>  '菜单地址长度不能超过50个字符！',
        'sort.require'          =>  '菜单排序值必须填写！',
        'sort.between'          =>  '菜单排序值在0-100之间！'
    ];

    protected $scene = [
        'createRole'    =>  ['roleName'],
        'createMenu'    =>  ['menu_name', 'parent_menu', 'menu_adds', 'menu_icon', 'sort']
    ];
}