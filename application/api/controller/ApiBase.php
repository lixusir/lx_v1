<?php
namespace app\api\controller;
use think\Controller;
class ApiBase extends Controller{
    public function _initialize()
    {
        parent::_initialize();
//        //判断是否有登录
//        $admin_id = session('admin_id');
//        $login_url = url('login/index');
//        if(empty($admin_id)){
//            $logexc = <<<EOF
//            <script>window.location.href="$login_url"</script>
//EOF;
//            echo $logexc;
//        }
    }
}