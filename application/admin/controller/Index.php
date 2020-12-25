<?php

namespace app\admin\controller;
use app\model\MsgUser as msgUserModel;
use app\admin\model\Admin as adminModel;
use app\admin\validate\Login;
use think\Log;

class Index extends AdminBase
{
    public function _initialize()
    {
        parent::_initialize(); //
    }

    public function set(){


        $adminId = session('admin_id');
        $adminInfo = adminModel::where(['id'=>$adminId])->find();

        if(request()->isPost()){

            $param = input('param.');

            $adminModel = new adminModel();

            $data = [];
            $data['oldPassword'] = encrypt($param['oldPassword']);
            $data['setpassword'] = $param['setpassword'];
            $data['repassword'] = $param['repassword'];
            $data['password'] = $adminInfo['password'];

            $login = new Login();

            $result = $login->check($data);

            if(!$result){

                $this->error($login->getError());
            }

            $result = $adminModel -> allowField(true) -> setpwd($param,$adminId);

            if($result['code'] != 200){

                $this->error($result['msg']);

            }else{

                $this->success($result['msg']);

            }

        }

        return $this->fetch('index/password');
    }
    public function index()
    {
        //获取用户余额
        $adminId = session('admin_id');
        $adminInfo = adminModel::where(['id'=>$adminId])->find();
        //获取是否有未读消息
        $now = time();
        $map = [
            'status' => 1,
            'platform'=>['IN',[0,1]],
            'create_time'=>['elt',$now],
            'end_time'=>['egt',$now],
        ];
        $msgInfo = db('Message')->where($map)->column('id,type,title,content,platform');

        $msgCount = 0;
        $msgNoInfo = [];//未读弹窗消息
        $msgIsNo = 0;
        if(count($msgInfo)>0){
            //获取未读消息
            $msgUser = msgUserModel::where(['user_type'=>3,'user_id'=>$adminId])->column('msg_id,is_read');
            foreach($msgInfo as $k=>$value){
                if(!isset($msgUser[$value['id']])){
                    $msgCount++;
                    if($value['type']==1 && $adminId!=1){
                        //未读弹窗消息
                        $msgNoInfo['id'] = $value['id'];
                        $msgNoInfo['title'] = $value['title'];
                        $msgNoInfo['content'] = $value['content'];
                        $msgIsNo =1;
                    }
                }
            }
        }
        $this->assign('msg_count',$msgCount);
        $this->assign('msgNoInfo',$msgNoInfo);
        $this->assign('msgIsNo',$msgIsNo);
        $this->assign('user_money',$adminInfo['user_money']);
        $sysRule = session('menu_arr');
//        dump($sysRule);exit;
        $this->assign('sys_rule', $sysRule);
        return $this->fetch();
    }

    /*
     * 退出登录
     */
    public function logout()
    {
        //记录日志
        $log_data = [
            'type' => 1,
            'user_id' => session('admin_id'),
            'user_name' => session('admin_name'),
            'out_time' => time(),
            'out_ip' => getIpAddress(),
        ];

        db('LoginLog')->insert($log_data);
        session('admin_id', NULL);
        session('admin_name', NULL);
        session('admin_mobile', NULL);
        session('superior_id', NULL);
        session('menu_arr', NULL);//清除权限菜单
        session('rule_arr', NULL);//清除权限数组
        session('group_arr', NULL);//清除用户组数组
        $this->success('退出成功', url('Login/index'));
    }

    public function console()
    {
        $info = [
            'ver' => 'v1.0.1',
            'kj' => THINK_VERSION,
            'ts' => '极简操作',
            'sys' => $_SERVER["SERVER_SOFTWARE"],
        ];
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function home1()
    {
        return $this->fetch();
    }

}