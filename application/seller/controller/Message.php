<?php
namespace app\seller\controller;
use app\model\Message as messageModel;
use app\model\MsgUser as msgUserModel;
class Message extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 消息列表
     */
    public function msgList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['platform'] = ['IN',[0,2]];
            $list = messageModel::where($where)->order('sort desc')->paginate($pageSize)->toArray();
            if(!empty($list)){
                $sellerId = session('seller_id');
                $msgUser = msgUserModel::where(['user_type'=>2,'user_id'=>$sellerId])->column('msg_id,is_read');
                foreach($list['data'] as $k=>&$value){
                    if(isset($msgUser[$value['id']])){
                        $value['is_read'] = 1;
                    }else{
                        $value['is_read'] = 0;
                    }
                    if($value['type']==2 && !empty($value['url'])){
                        $value['jump_url'] = $value['url'];
                        $value['target']='_blank';
                    }else{
                        $value['jump_url'] = url('Message/msgView',['id'=>$value['id']]);
                        $value['target']='_self';
                    }
                }
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
    /*
     * 消息详情
     */
    public function msgView(){
        $linkage = linkage('message');
        $id = input('param.id/d');
        $info = messageModel::where(['id'=>$id])->find();
        $this->assign('info',$info);
        $this->assign('linkage',$linkage);
        return $this->fetch();
    }
    /*
     * 标记消息已读
     */
    public function setMsgStatus(){
        if(request()->isPost()){
            $ids=input('param.ids/a');
            $sellerId = session('seller_id');
            if(!empty($ids)){
                $userMsgIds=msgUserModel::where(['user_id'=>$sellerId,'user_type'=>2])->column('msg_id,is_read');
                foreach ($ids as $val){
                    if(empty($userMsgIds[$val])){
                        $data[]=[
                            'user_id'=>$sellerId,
                            'user_type'=>2,
                            'msg_id'=>$val,
                            'is_read'=>1,
                        ];
                    }
                }
                if(!empty($data)){
                    $userMsg=new msgUserModel();
                    $userMsg->saveAll($data);
                }
            }
            $this->success('操作成功',url('Message/msgList'));
        }

    }
}