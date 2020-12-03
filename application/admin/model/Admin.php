<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use app\admin\model\Commission as commModel;
class Admin extends Model{
    /*
     * 管理员编辑
     */
    public function doAdminEdit($reqData,$admin_id){
        Db::startTrans();
        try{
            $error = ['code'=>0,'msg'=>'error'];
            $data = [
                'group_id'=>$reqData['group_id'],
                'user_name'=>$reqData['user_name'],
                'password'=> encrypt($reqData['password']),
                'real_name'=>$reqData['real_name'],
                'phone'=>$reqData['phone'],
                'superior_id'=>$admin_id,
                'bank_name'=>$reqData['bank_name'],
                'bank_number'=>$reqData['bank_number'],
                'status'=>$reqData['status'],
            ];
            $aId = $reqData['id'];
            if(isset($aId) && !empty($aId)){
                $data['id'] = $aId;
                //查找用户
                $admins = self::where(['superior_id'=>$admin_id,'id'=>$aId])->find();
                if(!$admins && $admin_id!=1 ){
                    $error['msg'] = '非法操作';
                    return $error;
                }
                if(empty($reqData['password'])){
                    unset($data['password']);
                }
                $result = self::update($data);
                if(!$result){
                    $error['msg'] = '编辑管理员失败';
                    return $error;
                }
                //超级管理员操作
                if($admin_id==1){
                    //判断是否有佣金数据
                    $isComm = db('Commission')->where(['superior_id'=>$aId])->count();
                    if($isComm<=0){
                        //创建一份超级管理员佣金设置数据
                        $commissionRes = db('Commission')->where(['type_id'=>2,'superior_id'=>1])->select();
                        $comData = [];
                        foreach($commissionRes as $key=>$value){
                            $comData[$key]['name'] = $value['name'];
                            $comData[$key]['superior_id'] = $aId;
                            $comData[$key]['start'] = $value['start'];
                            $comData[$key]['end'] = $value['end'];
                            $comData[$key]['type_id'] = 2;
                            $comData[$key]['val'] = $value['val'];
                            $comData[$key]['sort'] = $value['sort'];
                        }
                        $commModel = new commModel();
                        $comResult = $commModel->saveAll($comData);
                        if(!$comResult){
                            $error['msg'] = '创建佣金失败';
                            return $error;
                        }
                    }
                }
            }else{
                if(empty($reqData['password'])){
                    $error['msg'] = '登录密码必须输入';
                    return $error;
                }
                $data['create_time'] = time();
                $result = db('admin')->insertGetId($data);
                if(!$result){
                    $error['msg'] = '创建管理员失败';
                    return $error;
                }
                //超级管理员操作
                if($admin_id==1){
                    //创建一份超级管理员佣金设置数据
                    $commissionRes = db('Commission')->where(['type_id'=>2,'superior_id'=>1])->select();
                    $comData = [];
                    foreach($commissionRes as $key=>$value){
                        $comData[$key]['name'] = $value['name'];
                        $comData[$key]['superior_id'] = $result;
                        $comData[$key]['start'] = $value['start'];
                        $comData[$key]['end'] = $value['end'];
                        $comData[$key]['type_id'] = 2;
                        $comData[$key]['val'] = $value['val'];
                        $comData[$key]['sort'] = $value['sort'];
                    }
                    $commModel = new commModel();
                    $comResult = $commModel->saveAll($comData);
                    if(!$comResult){
                        $error['msg'] = '创建佣金失败';
                        return $error;
                    }
                }
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }
    /*
     * 登录
     */
     public function loginIn($param){
         $error = ['code'=>0,'msg'=>'error'];
         $user_name = $param['user_name'];
         $password = $param['password'];
         $admin = self::where(['user_name'=>$user_name])->find();
         if(!$admin){
             $error['msg'] = '用户不存在';
             return $error;
         }
         $pwd = encrypt($password);
         if($pwd !=$admin['password']){
             $error['msg'] = '密码错误，请重新输入';
             return $error;
         }
         if($admin['status']!=1){
             $error['msg'] = '账号被禁用，请联系客服';
             return $error;
         }
         //获取用户权限
         $group = db('AdminGroup')->where(['id'=>$admin['group_id']])->find();
         if(!$group){
             $error['msg'] = '用户权限不正常，请联系客服';
             return $error;
         }
         $res = [];
         $res['id'] = $admin['id'];
         $res['user_name'] = $admin['user_name'];
         $res['admin_mobile'] = $admin['phone'];
         $res['superior_id'] = $admin['superior_id'];
         $sysRules = getSysRule($group['rules'],$admin['id']);
         $res['menu_arr'] = $sysRules['menu_arr'];
         $res['rule_arr'] = $sysRules['rule_arr'];
         $res['group_arr'] = $sysRules['group_arr'];
         //记录登录日志
         $log_data = [
             'type'=>1,
             'user_id'=>$admin['id'],
             'user_name'=>$admin['user_name'],
             'log_time'=>time(),
             'log_ip'=>getIpAddress(),
         ];
         db('LoginLog')->insert($log_data);
         return ['code'=>200,'msg'=>'成功','data'=>$res];
     }

     /*
      * 修改密码
      */

     public function setpwd($param,$adminId){

         Db::startTrans();
         try{



         }catch (\Exception $ex){


         }
         $setpassword = encrypt(trim($param['setpassword']));


     }
}
