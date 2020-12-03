<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as adminModel;
class Login extends Controller{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    public function set(){

        return $this->fetch();

    }
    /*
     * 登录
     */
    public function index(){
        //已登录，跳转至后台
         if(session('admin_id')){
             $this->redirect(url('Index/index'));
         }
         if(request()->isPost()){
              $posData = input('param.');
              if(!captcha_check($posData['vercode'])){
                   //$this->error('验证码错误，请重新输入');
              }

              $adminModel = new adminModel();
              $res = $adminModel->allowField(true)->loginIn($posData);
              if($res['code']!=200){
                  $this->error($res['msg']);
              }
              //保存SESSION
              session('admin_id',$res['data']['id']);
              session('admin_name',$res['data']['user_name']);
              session('admin_mobile',$res['data']['admin_mobile']);
              session('superior_id',$res['data']['superior_id']);
              session('menu_arr',$res['data']['menu_arr']);//用户权限菜单
              session('rule_arr',$res['data']['rule_arr']);//用户权限数组
              session('group_arr',$res['data']['group_arr']);//用户组数组
              $this->success('登录成功',url('Index/index'));
         }else{
             return $this->fetch();
         }
    }

}