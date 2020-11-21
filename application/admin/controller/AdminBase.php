<?php
namespace app\admin\controller;
use think\Controller;
class AdminBase extends Controller{
    public function _initialize()
    {
        parent::_initialize();
        //判断是否有登录
        $admin_id = session('admin_id');
        $login_url = url('login/index');
        if(empty($admin_id)){
            $logexc = <<<EOF
            <script>window.location.href="$login_url"</script>
EOF;
            echo $logexc;
        }
        //用户权限判断
        $auth_controller = request()->controller();//当前控制器名
        $auth_action = request()->action();//当前方法名
        $authUrl = strtolower($auth_controller).'/'.strtolower($auth_action);
//        dump($authUrl);
        //用户权限数组
        $userRule = session('rule_arr');
        //通用不做判断规则
        $rule_t = [
            'index/index',//主页
            'index/logout',//退出
            'index/console',//退出
            'upfiles/upload',//上传图片
        ];
        $userRule = array_merge($userRule,$rule_t);
//        dump($userRule);exit;
        if(!in_array($authUrl,$userRule) && $admin_id!=1){
            $this->error('非法访问');
        }
    }
}