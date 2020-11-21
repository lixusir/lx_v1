<?php

namespace app\admin\controller;

use app\model\WorkOrder as workOrderModel;
use app\admin\model\Notice as noticeModel;
class WorkOrder extends AdminBase
{
    public function _initialize()
    {
        parent::_initialize(); //
    }

    public function index()
    {
        $linkage = linkage('work_order');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $word_id = input('post.word_id');
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
        $admin_id = session('admin_id');
        //查找管理员下属用户
        $users = db('Admin')->where(['superior_id'=>$admin_id])->column('id,user_name');
        if (request()->isPost()) {
            $reqData = input('param.');
            $data = [
                'title' => $reqData['title'],
                'type' => $reqData['type'],
                'accept_time' => !empty($reqData['accept_time'])?strtotime($reqData['accept_time']):time(),
                'accept_userid' => $reqData['accept_userid'],
                'accept_name' => $users[$reqData['accept_userid']],
                'speed' => !empty($reqData['speed'])?$reqData['speed']:0,
                'content' => $reqData['content'],
                'status' => intval($reqData['status']),
            ];
            $workId = $reqData['id'];
            if (isset($workId) && !empty($workId)) {
                //查找工单
                $works = workOrderModel::where(['superior_id'=>$admin_id,'id'=>$workId])->find();
                if(!$works && $admin_id!=1 ){
                    $this->error('非法操作');
                }
                $data['id'] = $workId;
                $result = workOrderModel::update($data);
                if($result){
                    //判断是否已发送过通知
                    $notices = noticeModel::where(['msg_id'=>$works['id']])->find();
                    if(!$notices){
                        //发送通知
                        $n_log = [
                            'type'=>1,
                            'send_user_id'=>$admin_id,
                            'user_id'=>$reqData['accept_userid'],
                            'msg_id'=>$works['id'],
                            'title'=>'【工单号:'.$works['id'].'】'.$works['title'].'请处理',
                            'content'=>$works['content'],
                            'status'=>'0',
                            'create_time'=>time(),
                        ];
                        db('Notice')->insert($n_log);
                    }
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
            $this->assign('users', $users);
            $this->assign('linkage', $linkage);
            return $this->fetch('workorder/work_edit');
        }
    }

    /*
     * 工单删除
     */
    public function workDel()
    {
        $id = input('param.id');
        $info = workOrderModel::where(['id' => $id])->find();
        if (!$info) {
            $this->error('未找到内容');
        }
        $result = workOrderModel::where(['id' => $id])->delete();
        if ($result) {
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
}