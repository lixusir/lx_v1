<?php
/**
 * Created by PhpStorm.
 * User: 23688
 * Date: 2020/12/3
 * Time: 13:09
 */
namespace app\admin\validate;

use Think\Validate;

class Login extends Validate{

    protected $rule = [
        'oldPassword'=>'require|confirm:password',
        'setpassword' => 'require|length:6,16',
        'repassword' => 'require|confirm:setpassword',

    ];

    protected $message = [
        'oldPassword.require' => '请填写当前密码',
        'oldPassword.confirm' => '当前密码不正确',
        'setpassword.length' => '密码长度为6-16位',
        'setpassword.require' => '请输入新密码',
        'repassword.require' => '请输入确认密码',
        'repassword.confirm' => '与新密码不一致'
    ];

    protected $scene = [];
}