<?php
namespace app\model;
use think\Model;
use app\model\Account;
use think\Db;
class Recharge extends Model{
    /*
        * 充值审核
        */
    public function rechargeVerify($param=[]){
        $error = ['code'=>0,'msg'=>'error'];
        $admin_id = session('admin_id');
        $id = $param['id'];
        if(!isset($id) || empty($id)){
            $error['msg'] = '缺少参数';
            return $error;
        }
        //充值记录
        $recharge = self::where(['superior_id'=>$admin_id,'id'=>$id])->find();
        if(!$recharge){
            $error['msg'] = '充值记录不存在';
            return $error;
        }
        if($recharge['status']!=0){
            $error['msg'] = '当前状态非待审核状态，无法操作';
            return $error;
        }
        $up_data=[
            'id'=>$param['id'],
            'update_time'=>time(),
            'status'=>$param['status'],
            'remarks'=>$param['remarks'],
            'op_name'=>session('admin_name'),
        ];
        Db::startTrans();
        if($param['status']==1){
            //判断管理员资金是否充足
            $adminInfo = db('Admin')->where(['id'=>$admin_id])->find();
            if($adminInfo['user_money']<=0 || $adminInfo['user_money']< $recharge['money']){
                $error['msg'] = '您的余额不足，请充值';
                return $error;
            }
             //审核通过操作用户资金
            $accountModel = new Account();
            $acc_data = [];
            $acc_data['operate'] = 1;//资金类型 1增加 2减少
            $acc_data['user_id'] = $recharge['seller_id'];//操作商家ID
            $acc_data['user_type'] = $recharge['user_type'];//操作用户类型 1业务员 2商家 3管理员
            $acc_data['type'] = 2;//操作类型 1佣金 2充值 3退款
            $acc_data['amount'] = $recharge['money'];//操作金额
            $acc_data['remark'] = '用户充值';//操作备注
            $acc_res = $accountModel->doUserAccount($acc_data);
            if($acc_res['code']!=200){
                Db::rollback();
                $error['msg'] = $acc_res['msg'];
                return $error;
            }
            //操作管理员资金
            $acc_data = [];
            $acc_data['operate'] = 2;//资金类型 1增加 2减少
            $acc_data['user_id'] = $admin_id;//操作管理员ID
            $acc_data['user_type'] = 3;//操作用户类型 1业务员 2商家 3管理员
            $acc_data['type'] = 2;//操作类型 1佣金 2充值 3退款
            $acc_data['amount'] = $recharge['money'];//操作金额
            $acc_data['remark'] = '扣除商户充值金额';//操作备注
            $acc_res = $accountModel->doUserAccount($acc_data);
            if($acc_res['code']!=200){
                Db::rollback();
                $error['msg'] = $acc_res['msg'];
                return $error;
            }
        }
        $res = self::update($up_data);
        if(!$res){
            Db::rollback();
            $error['msg'] = '更新记录失败';
            return $error;
        }
        Db::commit();
        return ['code'=>200,'msg'=>'成功'];
    }
}
