<?php

namespace app\seller\controller;

use app\model\WorkOrder as workOrderModel;
class WorkOrder extends SellerBase
{
    public function _initialize()
    {
        parent::_initialize(); //
    }

    public function index()
    {
        $linkage = linkage('work_order');
        $seller_id = session('seller_id');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $word_id = input('post.word_id');
            $where['user_type'] = 2;
            $where['user_id'] = $seller_id;
            if (!empty($word_id)) {
                $where['id'] = $word_id;
            }
            $status = input('post.status');
            if (!empty($status)) {
                $where['status'] = $status;
            }
            $accept_name = input('post.accept_name');
            if (!empty($accept_name)) {
                $where['accept_name'] = $accept_name;
            }
            $title = input('post.title');
            if (!empty($title)) {
                $where['title'] = ['like', "%" . $title . "%"];
            }
            $list = workOrderModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach ($list['data'] as &$val) {
                $val['type_des'] = $linkage['type'][$val['type']];
                $val['status_text'] = $linkage['status'][$val['status']];
                $val['accept_time'] = !empty($val['accept_time'])?date('Y-m-d H:i:s',$val['accept_time']):'-';
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage', $linkage);
        return $this->fetch('workorder/index');
    }

    public function workEdit()
    {
        $linkage = linkage('work_order');
        $seller_id = session('seller_id');
        $seller_name = session('seller_name');
        $superior_id = session('superior_id');
        if (request()->isPost()) {
            $reqData = input('param.');
            $data = [
                'title' => $reqData['title'],
                'type' => $reqData['type'],
                'user_id' => $superior_id,
                'user_name' => $seller_name,
                'user_type' => 2,//用户类型 1业务员 2商家 3管理员
                'content' => $reqData['content'],
            ];
            $workId = $reqData['id'];
            $workModel = new workOrderModel();
            if (isset($workId) && !empty($workId)) {
                //查找工单
                $works = workOrderModel::where(['user_id'=>$seller_id,'user_type'=>2,'id'=>$workId])->find();
                if(!$works){
                    $this->error('非法操作');
                }
                $data['id'] = $workId;
                $result = workOrderModel::update($data);
            }else{
                $data['create_time'] = time();
                $data['status'] = 0;
                $result = $workModel->insertGetId($data);
                if($result){
                    //发送通知
                    $n_log = [
                        'type'=>1,
                        'send_user_id'=>0,
                        'user_id'=>$superior_id,
                        'user_type'=>3,//用户类型 1业务员 2商家 3管理员
                        'msg_id'=>$result,
                        'title'=>'【工单号:'.$result.'】'.$data['title'].'请处理',
                        'content'=>$data['content'],
                        'status'=>'0',
                        'create_time'=>time(),
                    ];
                    db('Notice')->insert($n_log);
                }
            }
            if ($result) {
                $this->success('操作成功', url('WorkOrder/index'));
            }
            $this->error('操作失败');
        } else {
            $id = input('get.id/d');
            $info = workOrderModel::where(['id' => $id])->find();
            $this->assign('info', $info);
            $this->assign('linkage', $linkage);
            return $this->fetch('workorder/work_edit');
        }
    }
}