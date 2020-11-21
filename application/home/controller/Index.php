<?php
namespace app\home\controller;

use app\model\Account;
use think\Log;
class Index
{
    public function index()
    {
        Log::write('测试日志信息，这是警告级别，并且实时写入','info');
//        //扣除商家佣金
//        $acc_data = [];
//        $acc_data['operate'] = 2;//资金类型 1增加 2减少
//        $acc_data['seller_id'] = 1;//操作商家ID
//        $acc_data['amount'] = 3;//操作金额
//        $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
//        $acc_data['remark'] = '扣除佣金[计划编号:]';//操作备注
//        $acc_res = Account::sellerAccount($acc_data);
//        dump($acc_res);
//        $pwd = '123456';
//        $res = encrypt($pwd);
//        dump($res);

    }
}
