<?php
namespace app\seller\controller;
use app\model\Seller as sellerModel;
use app\model\MsgUser as msgUserModel;
class Index extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    public function index(){
        //获取用户余额
        $sellerId = session('seller_id');
        $sellerInfo = sellerModel::where(['id'=>$sellerId])->find();
        //获取是否有未读消息
        $now = time();
        $map = [
            'status' => 1,
            'platform'=>['IN',[0,2]],
            'create_time'=>['elt',$now],
            'end_time'=>['egt',$now],
        ];
        $msgInfo = db('Message')->where($map)->column('id,type,title,content,platform');
        $msgCount = 0;
        $msgNoInfo = [];//未读弹窗消息
        $msgIsNo = 0;
        if(count($msgInfo)>0){
            //获取未读消息
            $msgUser = msgUserModel::where(['user_type'=>2,'user_id'=>$sellerId])->column('msg_id,is_read');
            foreach($msgInfo as $k=>$value){
                if(!isset($msgUser[$value['id']])){
                    $msgCount++;
                    if($value['type']==1){
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
        $this->assign('seller_money',$sellerInfo['user_money']);
        return $this->fetch();
    }

    /*
     * 退出登录
     */
    public function logout(){
        //记录日志
        $log_data = [
            'type'=>2,
            'user_id'=>session('seller_id'),
            'user_name'=>session('seller_name'),
            'out_time'=>time(),
            'out_ip'=>getIpAddress(),
        ];
        db('LoginLog')->insert($log_data);
        session('seller_id',NULL);
        session('seller_name',NULL);
        session('superior_id',NULL);
        $this->success('退出成功',url('Login/index'));
    }
    public function console(){
        $info = [
            'ver'=>'v1.0.1',
            'kj'=>THINK_VERSION,
            'ts'=>'极简操作',
            'sys'=>$_SERVER["SERVER_SOFTWARE"] ,
        ];
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function home1(){
        return $this->fetch();
    }

}