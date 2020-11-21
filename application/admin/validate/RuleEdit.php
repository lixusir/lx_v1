<?php
namespace app\admin\validate;
use think\Validate;
class RuleEdit extends Validate{
    //验证场景
    protected $scene = [
    ];
    //验证规则
    protected $rule = [
        'name' => 'require',
        'type' => 'require',
        'link' => 'require',
        'sort' => 'require',
        'spread' => 'require',
        'status' => 'require',
    ];
    //错误信息
    protected $message = [
    ];
    //字段描述
    protected $field = [
        'name' => '名称',
        'type' => '类型',
        'link' => '链接',
        'sort' => '排序',
        'spread' => '是否展开',
        'status' => '状态',
    ];
}
