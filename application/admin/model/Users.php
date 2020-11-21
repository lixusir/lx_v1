<?php
namespace app\admin\model;
use think\Model;
class Users extends Model{
    /*
     * 编辑新增用户
     */
     public function doEditUser($reqData){
         $error = ['code'=>0,'msg'=>'error'];
         $userId = $reqData['id'];
         $superior_id = session('admin_id');
         $superior_name = session('admin_name');
         $data = [
             'mobile' => $reqData['mobile'],
             'real_name' => $reqData['real_name'],
             'qq' => $reqData['qq'],
             'wechat' => $reqData['wechat'],
             'sex' => $reqData['sex'],
             'tb_user' => $reqData['tb_user'],
             'tb_credit' => $reqData['tb_credit'],
             'status' => $reqData['status'],
             'is_back' => $reqData['is_back'],
             'user_type' => $reqData['user_type'],
             'money_limit' => $reqData['money_limit'],
             'users_remark' => $reqData['users_remark'],
             'superior_id' => $superior_id,
             'superior_name' => $superior_name,
             'province' => $reqData['province'],
             'city' => $reqData['city'],
//             'verify_order_sn' => $reqData['verify_order_sn'],
             'invite_auth' => $reqData['invite_auth'],
             'bank_name' => !empty($reqData['bank_name']) ? $reqData['bank_name'] : '',
             'bank_number' => !empty($reqData['bank_number']) ? $reqData['bank_number'] : '',
             'bank_status' => $reqData['bank_status'],
             'front' => !empty($reqData['front']) ? $reqData['front'] : '',
             'reverse' => !empty($reqData['reverse']) ? $reqData['reverse'] : '',
             'pose' => !empty($reqData['pose']) ? $reqData['pose'] : '',
             'card_status' => $reqData['card_status'],
             'card_remark' => $reqData['card_remark'],
         ];
         if ($reqData['card_status'] == 1) {
             $data['is_real'] = 1;
         } else{
             $data['is_real'] = 0;
         }
         if ($reqData['bank_status'] == 1) {
             $data['is_bank'] = 1;
         } else{
             $data['is_bank'] = 0;
         }
         if(isset($reqData['first_leader']) && !empty($reqData['first_leader'])){
              //判断邀请人是否存在
              $invite = self::where(['id'=>$reqData['first_leader']])->find();
              if(!$invite){
                  $error['msg'] = '邀请人不存在';
                  return $error;
              }
         }
         if(isset($userId) && !empty($userId)){
             //判断用户是否存在
             $users = self::where(['id'=>$userId])->find();
             if(!$users){
                 $error['msg'] = '用户不存在';
                 return $error;
             }
             if(empty($reqData['password'])){
                 unset($data['password']);
             }
             $data['update_time'] = time();
             $result = self::where(['id'=>$userId])->update($data);
         }else{
             //新增
             if(isset($reqData['card_no']) && !empty($reqData['card_no'])){
                 //判断身份证号码是否存在
                 $cardInfo = self::where(['card_no'=>$reqData['card_no']])->find();
                 if($cardInfo){
                     $error['msg'] = '身份证号码已存在';
                     return $error;
                 }
             }
             //判断手机号码是否存在
             $mobileInfo = self::where(['mobile'=>$reqData['mobile']])->find();
             if($mobileInfo){
                 $error['msg'] = '手机号码已存在';
                 return $error;
             }
             if(empty($reqData['password'])){
                 $this->error('登录密码必须输入');
             }
             $data['password'] = encrypt($reqData['password']);
             $data['create_time'] = time();
             $result = self::create($data);
         }
         if($result){
             return ['code'=>200,'msg'=>'成功'];
         }
         return $error;
     }
}
