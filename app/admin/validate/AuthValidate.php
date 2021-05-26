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
        'roleName'  =>  'require|length:1,10'
    ];

    protected $message = [
        'roleName.require'  =>  '角色名称必须填写！',
        'roleName.length'   =>  '角色名称长度不能超过10个字符！'
    ];

    protected $scene = [
        'createRole'    =>  ['roleName'],
    ];
}