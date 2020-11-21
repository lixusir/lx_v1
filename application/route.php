<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    //api接口
    '[user]' => [
        'login' => ['api/user/login',[]],//登录
        'logout' => ['api/user/logout',[]],//退出登录
        'upPassword' => ['api/user/upPassword',[]],//修改密码
        'getUserInfo' => ['api/user/getUserInfo',[]],//获取用户信息
        'earnings' => ['api/user/earningsList',[]],//资金记录
        'withdraw' => ['api/user/subWithdraw',[]],//提现申请
        'withdrawList' => ['api/user/withdrawList',[]],//提现申请记录
        'card' => ['api/user/doCard',[]],//身份证认证
        'bindBank' => ['api/user/bindBank',[]],//绑定银行卡
        'workList' => ['api/user/workList',[]],//工单列表
        'workView' => ['api/user/workView',[]],//工单详情
        'workEdit' => ['api/user/workEdit',[]],//工单提交
        'noticeList' => ['api/user/noticeList',[]],//公告列表
        'noticeView' => ['api/user/noticeView',[]],//公告详情
    ],
    '[task]' => [
        'taskList' => ['api/task/getTaskList',[]],//任务列表
        'taskView' => ['api/task/getTaskView',[]],//任务详情
        'orderView' => ['api/task/getOrderView',[]],//任务订单详情
        'updateOrderInfo' => ['api/task/updateOrderInfo',[]],//更新订单信息
        'subTaskOrder' => ['api/task/subTaskOrder',[]],//提交任务单
    ],
];
