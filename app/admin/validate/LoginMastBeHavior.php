<?php


namespace app\admin\validate;


use think\facade\Validate;

class LoginMastBeHavior extends Validate
{
    protected $rule =   [
        'username'  => 'require',
        'password'   => 'require',
        'phone' => 'require|number|length:11',
        'code' => 'require',
    ];

    protected $message  =   [
        'username.require' => '账号必须填写',
        'password.require'     => '密码必须填写',
        'phone.require'     => '手机号必须填写',
        'phone.number'   => '手机号必须是数字',
        'phone.max'  => '手机号必须是11位',
        'code.require'        => '验证码必须填写',
    ];

    protected $scene = [
        'login'  =>  ['username','password'],
        'lost'  =>  ['phone','code'],
    ];
}