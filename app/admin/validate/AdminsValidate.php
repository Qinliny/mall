<?php


namespace app\admin\validate;


use think\Validate;

class AdminsValidate extends Validate
{
    protected $regex = [
        // 验证手机号码
        'checkPhone'        =>  '/^1[3|4|5|7|8][0-9]\d{4,8}$/',
        // 验证邮箱
        'checkEmail'        =>  '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',
        // 验证微信号码
        'checkWechatNumber' =>  '/^[a-zA-Z][a-zA-Z0-9_-]{5,19}$/',
        // 验证QQ号码
        'checkQQNumber'     =>  '/^[1-9][0-9]{4,12}$/',
        // 验证密码
        'checkPassword'     =>  '/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[._~!@#$^&*])[A-Za-z0-9._~!@#$^&*]{8,20}$/'
    ];

    protected $rule = [
        'admins_name'       =>  'require|max:10',
        'phone'             =>  'require|regex:checkPhone',
        'email'             =>  'require|regex:checkEmail|max:50',
        'wx_number'         =>  'regex:checkWechatNumber',
        'qq_number'         =>  'regex:checkQQNumber',
        'native_place'      =>  'require|max:50',
        'birthday'          =>  'require|date',
        'sex'               =>  'require|in:0,1',
        'password'          =>  'require|regex:checkPassword',
        'confirm_password'  =>  'require|confirm:password',
        'role'              =>  'require|integer'
    ];

    protected $message = [
        'admins_name.require'       =>  '请输入管理员姓名！',
        'admins_name.max'           =>  '管理员姓名长度不能超过10位！',
        'phone.require'             =>  '请输入手机号码！',
        'phone.regex'               =>  '请输入正确的手机号码！',
        'email.require'             =>  '请输入邮箱！',
        'email.regex'               =>  '请输入正确的邮箱格式！',
        'email.max'                 =>  '邮箱长度不能超过50位！',
        'wx_number.regex'           =>  '请输入正确的微信号！',
        'qq_number.regex'           =>  '请输入正确的QQ号！',
        'native_place.require'      =>  '请输入籍贯！',
        'native_place.nax'          =>  '籍贯的长度不能超过50位',
        'birthday.require'          =>  '请选择出生年月日！',
        'birthday.date'             =>  '请选择正确的时间格式！',
        'sex.require'               =>  '请选择性别！',
        'sex.in'                    =>  '性别参数有误！',
        'password.require'          =>  '请输入密码！',
        'password.regex'            =>  '密码由字母、数字、特殊符号(._~!@#$^&*)组成，区分大小写，长度为8-20位！',
        'confirm_password.require'  =>  '请再次输入密码！',
        'confirm_password.confirm'  =>  '两次输入的密码不一致，请重新输入！',
        'role.require'              =>  '请选择角色！',
        'role.integer'              =>  '选择的角色参数不正确！'
     ];

    protected $scene = [
        'create'    =>  [
            'admins_name', 'phone', 'email', 'wx_number', 'qq_number', 'native_place', 'birthday', 'sex', 'password', 'confirm_password', 'role'
        ]
    ];

}