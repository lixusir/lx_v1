<?php
namespace app\model;
use think\Model;
use think\Db;
use app\model\Account;
use app\model\Withdraw;
class Users extends Model{
    public function task()
    {
        return $this->hasMany('Task','user_id','id');
    }
    public function order()
    {
        return $this->hasMany('Order','user_id','id');
    }
    /*
     * 登录
     */
    public function doLogin($regData){
        $error = ['code'=>0,'msg'=>'error'];
         try{
             if(!isset($regData['account']) || empty($regData['account'])){
                  $error['msg'] = '登录手机号不能为空';
                  return $error;
             }
             if(!isset($regData['password']) || empty($regData['password'])){
                 $error['msg'] = '登录密码不能为空';
                 return $error;
             }
             $users = db('Users')->where(['mobile'=>$regData['account']])->find();
             if(!$users){
                 $error['msg'] = '用户不存在';
                 return $error;
             }
             if($users['status']==0 || $users['is_back']==1){
                 $error['msg'] = '账号被禁用，请联系管理员';
                 return $error;
             }
             $pwd = encrypt($regData['password']);
             if($users['password'] !=$pwd){
                 $error['msg'] = '登录密码错误 ，请重新输入';
                 return $error;
             }
             //登录日志
             $log_data = [
                 'type'=>3,
                 'user_id'=>$users['id'],
                 'user_name'=>$users['mobile'],
                 'log_time'=>time(),
                 'log_ip'=>getIpAddress(),
             ];
             $logRes = db('LoginLog')->insert($log_data);
             if(!$logRes){
                 $error['msg'] = '生成登录日志失败';
                 return $error;
             }
             $uid = ['uid'=>$users['id']];
             $token = setTokenVar($uid);
             $res = [
                 'token'=> $token,
                 'account'=> $users['mobile'],
                 'name'=> $users['real_name'],
                 'first_leader'=> $users['first_leader'],
                 'superior_id'=> $users['superior_id'],
                 'superior_name'=> $users['superior_name'],
                 'user_money'=> $users['user_money'],
                 'tb_user'=> $users['tb_user'],
                 'invite_auth'=> $users['invite_auth'],
             ];
             return ['code'=>200,'msg'=>'登录成功','data'=>$res];
         }catch(\Exception $ex){
             throw $ex;
         }
    }
    /*
     * 用户提现
     */
    public function doWithdraw($reqData,$userInfo){
        Db::startTrans();
        try{
            $error = ['code'=>0,'msg'=>'error'];
            $methods = $reqData['methods'];
            $money = $reqData['money'];
            $password = $reqData['password'];
            $withType = linkage('withdraw')['type'];
            if(empty($money) || !is_numeric($money)){
                $error['msg'] = '提现金额不能为空或必须为数字';
                return $error;
            }
            if(empty($password)){
                $error['msg'] = '登录密码不能为空';
                return $error;
            }
            if (encrypt($password) != $userInfo['password']) {
                $error['msg'] = '登录密码不正确';
                return $error;
            }
            if (empty($withType[$methods])) {
                $error['msg'] = '提现类型不正确';
                return $error;
            }
            $userMoney = $userInfo['user_money']; //用户余额
            if ($money > $userMoney) {
                $error['msg'] = '余额不足';
                return $error;
            }
            $sysCfg = db('SystemConfig')->find(1);
            //提现的次数限制
            //获取当天提现次数
            $mapDay = [
                'status' => ['IN',[0,1]], //提现的状态为申请中和申请成功的
                'user_id' => $userInfo['id'],
            ];
            $todayCount = db('withdraw')->where($mapDay)->whereTime('create_time','today')->count();
            if ($todayCount >= $sysCfg['day_cash_num'] && !empty($sysCfg['day_cash_num'])) {
                $error['msg'] = '每天最多只能提现'.$sysCfg['day_cash_num'].'次';
                return $error;
            }
            //获取本月提现总次数
            $mapMonth = [
                'status' => ['IN',[0,1]],//提现的状态为申请中和申请成功的
                'user_id' => $userInfo['id'],
            ];
            $monthCount = db('withdraw')->where($mapMonth)->whereTime('create_time','month')->count();
            if ($monthCount >= $sysCfg['month_cash_num'] && !empty($sysCfg['month_cash_num'])) {
                $error['msg'] = '每月最多只能提现'.$sysCfg['month_cash_num'].'次';
                return $error;
            }
            $data = [
                'user_id' => $userInfo['id'],
                'user_type' => $userInfo['user_type'],
                'type_id' => $methods,
                'money' => $money,
                'create_time' => time(),
            ];
            $withRes = db('withdraw')->insert($data);
            if(!$withRes){
                Db::rollback();
                $error['msg'] = '生成提现记录失败';
                return $error;
            }
            //提现金额直接扣减
            $accountModel = new Account();
            $acc_data = [];
            $acc_data['operate'] = 2;//资金类型 1增加 2减少
            $acc_data['user_id'] = $userInfo['id'];//操作用户ID
            $acc_data['user_type'] = 1;//操作用户类型 1业务员 2商家 3管理员
            $acc_data['type'] = 4;//操作类型 1佣金 2充值 3退款 4提现
            $acc_data['amount'] = $money;//操作金额
            $acc_data['remark'] = '用户提现';//操作备注
            $acc_res = $accountModel->doUserAccount($acc_data);
            if($acc_res['code']!=200){
                Db::rollback();
                $error['msg'] = $acc_res['msg'];
                return $error;
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            throw $ex;
        }
    }
    /*
     * 实名认证提交
     */
    public function userDoCard($reqData,$userInfo){
        try{
            $error = ['code'=>0,'msg'=>'error'];
            if(!isset($reqData['card_no']) || empty($reqData['card_no'])){
                $error['msg'] = '请填写身份证号码';
                return $error;
            }
            if(!isIdCard($reqData['card_no'])){
                $error['msg'] = '身份证号码格式错误';
//                return $error;
            }
            //判断身份证号是否存在
            if(!empty($userInfo['card_no']) && $reqData['card_no'] != $userInfo['card_no']){
                $cardRes = db('Users')->where(['card_no'=>$reqData['card_no']])->find();
                if($cardRes){
                    $error['msg'] = '身份证已存在，请重新提交';
                    return $error;
                }
            }
            $data = [];
            $data['update_time'] = time();
            $data['card_status'] = 1;
            $data['card_no'] = $reqData['card_no'];
            //处理身份证图片
            $file1 = request()->file('front');
            $info1 = $file1->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'front' );
            $imgPath = '/uploads/front/'.date('Ymd').'/';
            if($info1){
                $imgName = $imgPath.$info1->getFilename();
                $data['front'] = $imgName;
            }else{
                $error['msg'] = '身份证正面上传失败';
                return $error;
            }
            $file2 = request()->file('reverse');
            $info2 = $file2->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'reverse' );
            $imgPath = '/uploads/reverse/'.date('Ymd').'/';
            if($info2){
                $imgName = $imgPath.$info2->getFilename();
                $data['reverse'] = $imgName;
            }else{
                $error['msg'] = '身份证反面上传失败';
                return $error;
            }
            $userRes = db('Users')->where(['id'=>$userInfo['id']])->update($data);
            if(!$userRes){
                $error['msg'] = '更新用户信息失败';
                return $error;
            }
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            throw $ex;
        }
    }
    /*
     * 银行卡认证提交
     */
    public function userDoBank($reqData,$userInfo){
        try{
            $error = ['code'=>0,'msg'=>'error'];
            if(!isset($reqData['bank_number']) || empty($reqData['bank_number'])){
                $error['msg'] = '请填写银行卡号';
                return $error;
            }
            if(!is_numeric($reqData['bank_number'])){
                $error['msg'] = '银行卡号格式错误';
                return $error;
            }
            //判断银行卡号是否存在
            if(!empty($userInfo['bank_number']) && $reqData['bank_number'] != $userInfo['bank_number']){
                $cardRes = db('Users')->where(['bank_number'=>$reqData['bank_number']])->find();
                if($cardRes){
                    $error['msg'] = '银行卡号已存在，请重新提交';
                    return $error;
                }
            }
            $data = [];
            $data['update_time'] = time();
            $data['bank_status'] = 1;
            $data['bank_name'] = $reqData['bank_name'];
            $data['bank_number'] = $reqData['bank_number'];
            $userRes = db('Users')->where(['id'=>$userInfo['id']])->update($data);
            if(!$userRes){
                $error['msg'] = '更新用户银行卡信息失败';
                return $error;
            }
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            throw $ex;
        }
    }
}
