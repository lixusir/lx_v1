<?php
namespace app\seller\controller;
use think\Controller;
class SellerBase extends Controller{
    public function _initialize()
    {
        parent::_initialize();
        //判断是否有登录
        $seller_id = session('seller_id');
        $login_url = url('login/index');
        if(empty($seller_id)){
            $logexc = <<<EOF
            <script>window.location.href="$login_url"</script>
EOF;
            echo $logexc;
        }
    }
}