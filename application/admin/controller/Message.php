<?php
namespace app\admin\controller;
use app\model\Message as messageModel;
use app\model\MsgUser as msgUserModel;

class Message extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    public function msgList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $status = input('post.status');
            if (!empty($status)) {
                $where['status'] = $status;
            }
            $title = input('post.title');
            if (!empty($title)) {
                $where['title'] = ['like', "%" . $title . "%"];
            }
            $list = messageModel::where($where)->order('sort desc')->paginate($pageSize)->toArray();
            $linkage = linkage('message');
            foreach ($list['data'] as &$val){
                $val['begin_time']=date('Y-m-d H:i',$val['begin_time']);
                $val['end_time']=date('Y-m-d H:i',$val['end_time']);
                $val['plat_des']= $linkage['platform'][$val['platform']];
                $val['type_des']=$linkage['type'][$val['type']];
                $val['status_des']=$linkage['status'][$val['status']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
    public function msgEdit(){
        $linkage = linkage('message');
        if(request()->isPost()){
            $reqData = input('param.');
            $beginTime=strtotime($reqData['begin_time']);
            $endTime=strtotime($reqData['end_time']);
            if($endTime < $beginTime){
                $this->error('结束时间不能大于开始时间');
            }
            if(!empty($reqData['url'])){
                $pattern_1 = "/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/";
                if(!preg_match($pattern_1, $reqData['url'])){
                    $this->error('跳转链接地址格式不合法');
                }
            }
             $data = [
                 'title'=>$reqData['title'],
                 'type'=>$reqData['type'],
                 'platform'=>$reqData['platform'],
                 'url'=>$reqData['url'],
                 'begin_time'=>$beginTime,
                 'end_time'=>$endTime,
                 'content'=>$reqData['content'],
                 'status'=>intval($reqData['status']),
             ];
             $msgId = $reqData['id'];
             if(isset($msgId) && !empty($msgId)){
                 $data['id'] = $msgId;
                 $result = messageModel::update($data);
             }else{
                 $data['create_time'] = time();
                 $result = messageModel::create($data);
             }
             if($result){
                 $this->success('操作成功',url('Message/msgList'));
             }
             $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = messageModel::where(['id'=>$id])->find();
            $this->assign('info',$info);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 公告删除
     */
    public function msgDel(){
        $id = input('param.id');
        $info = messageModel::where(['id'=>$id])->find();
        if(!$info){
            $this->error('未找到内容');
        }
        $result = messageModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

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
            $adminId = session('admin_id');
            if(!empty($ids)){
                $userMsgIds=msgUserModel::where(['user_id'=>$adminId,'user_type'=>3])->column('msg_id,is_read');
                foreach ($ids as $val){
                    if(empty($userMsgIds[$val])){
                        $data[]=[
                            'user_id'=>$adminId,
                            'user_type'=>3,
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