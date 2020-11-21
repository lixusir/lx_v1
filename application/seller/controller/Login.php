<?php
namespace app\seller\controller;
use think\Controller;
use app\model\Seller as sellerModel;
class Login extends Controller{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 登录
     */
    public function index(){
        //已登录，跳转至后台
         if(session('seller_id')){
             $this->redirect(url('Index/index'));
         }
         if(request()->isPost()){
              $posData = input('param.');
              if(!captcha_check($posData['vercode'])){
                   $this->error('验证码错误，请重新输入');
              }
              $sellerModel = new sellerModel();
              $res = $sellerModel->allowField(true)->loginIn($posData);
              if($res['code']!=200){
                  $this->error($res['msg']);
              }
              //保存SESSION
              session('seller_id',$res['data']['id']);
              session('seller_name',$res['data']['user_name']);
              session('seller_mobile',$res['data']['mobile']);
              session('superior_id',$res['data']['superior_id']);
              $this->success('登录成功',url('Index/index'));
         }else{
             return $this->fetch();
         }
    }

}