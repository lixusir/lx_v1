<?php
namespace app\model;
use think\Model;
use app\model\Users as userModel;
use app\model\Seller as sellerModel;
use app\admin\model\Admin as adminModel;
class Account extends Model{

    /*
    * 通用资金操作
    * $operate 资金类型 1增加 2减少
    * $amount 操作金额
    * $remark 操作备注
    * $type 操作类型 1佣金 2充值 3退款
    */
    public static function doUserAccount($param){
        $error = ['code'=>0,'msg'=>'error'];
        $operate = isset($param['operate']) && $param['operate']==2?2:1;
        $user_id = $param['user_id'];//操作用户ID
        $user_type = $param['user_type'];//操作用户类型 1业务员 2商家 3管理员
        $type = $param['type'];//操作类型 1佣金 2充值 3退款
        $amount = $param['amount'];//操作金额
        $remark = $param['remark'];//操作备注
        if(!isset($user_id) || empty($user_id)){
            $error['msg'] = '用户ID不能为空';
            return $error;
        }
        if(!isset($user_type) || empty($user_type) || !in_array($user_type,[1,2,3])){
            $error['msg'] = '用户类型不能为空';
            return $error;
        }
        if($user_type==1){
            $userModel = new userModel();
        }elseif($user_type==2){
            $userModel = new sellerModel();
        }elseif($user_type==3){
            $userModel = new adminModel();
        }
        $userInfo = $userModel->where(['id'=>$user_id])->find();
        if(!$userInfo){
            $error['msg'] = '用户不存在';
            return $error;
        }
        if(!isset($type) || empty($type)){
            $error['msg'] = '操作类型不能为空';
            return $error;
        }
        if(!isset($amount) || empty($amount) || $amount==0){
            $error['msg'] = '操作金额不能为空或为零';
            return $error;
        }
        if(!isset($remark) || empty($remark)){
            $error['msg'] = '操作备注不能为空';
            return $error;
        }
        if(!is_numeric($amount)){
            $error['msg'] = '操作金额必须为数值';
            return $error;
        }
        //操作用户资金
        $old_money = $userInfo['user_money'];
        if($operate==1){
            //资金增加
            $new_money = floatval(bcadd($old_money,$amount));
        }else{
            //资金减少
            $new_money = floatval(bcsub($old_money,$amount));
        }
        if($new_money<=0){
            $error['msg'] = '用户余额不足';
            return $error;
        }
        $s_acc = $userModel->where(['id'=>$user_id])->setField('user_money',$new_money);
        if(!$s_acc){
            $error['msg'] = '操作用户资金失败';
            return $error;
        }
        //生成资金记录
        $acc_log = [];
        $acc_log['user_type'] = $user_type;//用户类型
        $acc_log['user_id'] = $user_id;//用户ID
        $acc_log['old_money'] = $old_money;//原来金额
        $acc_log['exc_money'] = $amount;//操作金额
        $acc_log['user_money'] = $new_money;//变更后金额
        $acc_log['desc'] = $remark;//描述
        $acc_log['plan_id'] = isset($param['plan_id'])?$param['plan_id']:'0';//计划ID
        $acc_log['create_time'] = time();//变动时间
        $acc_log['type'] = $type;//0 未分类 1任务佣金 2充值
        $acc_log['operate'] = $operate;//操作类型 1增加 2减少
        $log_res = db('AccountLog')->insert($acc_log);
        if(!$log_res){
            $error['msg'] = '生成用户资金记录失败';
            return $error;
        }
        return ['code'=>200,'msg'=>'操作成功'];
    }

    /*
     * 获取商家佣金
     * $sellerId 商家ID
     * $shopId 店铺ID
     * $money 计划金额
     */
    public static function getSellerCommission($sellerId,$superiorId,$shopId,$money){
        $error = ['code'=>0,'msg'=>'error'];
        if(!isset($money) || empty($money)){
            $error['msg'] = '缺少金额参数';
            return $error;
        }
        $where = [
            'start' => ['ELT', $money],
            'end' => ['GT', $money],
            'type_id' => 2,// 1刷手 2商家
            'superior_id' => $superiorId,// 联盟用户ID
        ];
        $defaultConf = db('Commission')->where($where)->find();
        if (!$defaultConf) {
            $error['msg'] = '抱歉，未找到佣金设置';
            return $error;
        }
        $comId = $defaultConf['id'];
        $sellerCof = db('CommissionSeller')->where(['seller_id' => $sellerId, 'shop_id' => $shopId, 'com_id' => $comId])->find();
        if (!empty($sellerCof['val'])) {
            $setMoney = $sellerCof['val'];
        } else {
            $setMoney = $defaultConf['val'];
        }
        return $setMoney;
    }
    /*
     * 获取刷手佣金
     */
    public static function getUserCommission($money)
    {
        $error = ['code'=>0,'msg'=>'error'];
        if(!isset($money) || empty($money)){
            $error['msg'] = '缺少金额参数';
            return $error;
        }
        $where = [
            'start' => ['ELT', $money],
            'end' => ['EGT', $money],
            'type_id' => 1, //1刷手
        ];
        $defaultConf = db('Commission')->where($where)->find();
        if (!$defaultConf) {
            $error['msg'] = '抱歉，未找到佣金设置';
            return $error;
        }
        $setMoney = $defaultConf['val'];
        return $setMoney;
    }
}
