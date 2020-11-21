<?php
namespace app\model;
use think\Model;
class Seller extends Model{
    /*
     * 登录
     */
    public function loginIn($param){
        $error = ['code'=>0,'msg'=>'error'];
        $user_name = $param['user_name'];
        $password = $param['password'];
        $seller = self::where(['name'=>$user_name])->find();
        if(!$seller){
            $error['msg'] = '用户不存在';
            return $error;
        }
        $pwd = encrypt($password);
        if($pwd !=$seller['password']){
            $error['msg'] = '密码错误，请重新输入';
            return $error;
        }
        if($seller['status']!=1){
            $error['msg'] = '账号被禁用，请联系客服';
            return $error;
        }
        $res = [];
        $res['id'] = $seller['id'];
        $res['user_name'] = $seller['name'];
        $res['superior_id'] = $seller['superior_id'];
        $res['mobile'] = $seller['mobile'];
        //记录登录日志
        $log_data = [
            'type'=>2,
            'user_id'=>$seller['id'],
            'user_name'=>$seller['name'],
            'log_time'=>time(),
            'log_ip'=>getIpAddress(),
        ];
        db('LoginLog')->insert($log_data);
        return ['code'=>200,'msg'=>'成功','data'=>$res];
    }
}
