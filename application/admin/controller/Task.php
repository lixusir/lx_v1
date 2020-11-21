<?php
namespace app\admin\controller;
use app\model\Task as taskModel;
class Task extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 任务列表
     */
    public function taskList()
    {
        $linkage = linkage('task');
        $admin_id = session('admin_id');
        $type = input('param.type',1);
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['superior_id'] = $admin_id;
            if($type==1){
                $where['status'] = ['IN',[1,2]];
            }elseif($type==2){
                $where['status'] = 4;
            }
            $task_sn = input('post.task_sn');
            if (isset($task_sn) && $task_sn != '') {
                $where['task_sn'] = $task_sn;
            }
            $tuan_user_name = input('post.tuan_user_name');
            if (isset($tuan_user_name) && $tuan_user_name != '') {
                $where['tuan_user_name'] = $tuan_user_name;
            }
            $user_name = input('post.user_name');
            if (isset($user_name) && $user_name != '') {
                $where['user_name'] = $user_name;
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $list = taskModel::withCount(['order'=> function($query){
                $maps = [
                    'status'=>1
                ];
                $query->where($maps);
            }])->with('pic')->where($where)->order('id desc')->paginate($pageSize)->toArray();
            $cityRes = db('Cities')->column('cityid,city');
            foreach ($list['data'] as &$val){
                $val['status_text']=$linkage['status'][$val['status']];
                //任务主图
                $val['task_pic'] = isset($val['pic'][0]['pic'])?$val['pic'][0]['pic']:'/static/images/no_image.gif';
                //地区
                $val['city_name'] = $cityRes[$val['city']];


            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('type',$type);
        $this->assign('linkage',$linkage);
        return view();
    }

    /*
     * 审核计划
     */
    public function taskEdit(){
        $linkage = linkage('task');
        $admin_id = session('admin_id');
        if(request()->isPost()){
            $reqData = input('param.');
            $data = [
                'title'=>$reqData['title'],
                'type'=>$reqData['type'],
                'platform'=>$reqData['platform'],
                'url'=>$reqData['url'],
                'content'=>$reqData['content'],
                'status'=>intval($reqData['status']),
            ];
            $tId = $reqData['id'];
            if(isset($tId) && !empty($tId)){
                $data['id'] = $tId;
                $result = taskModel::update($data);
            }
            if($result){
                $this->success('操作成功',url('Task/taskList'));
            }
            $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = taskModel::with('order')->where(['superior_id'=>$admin_id,'id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
            //获取任务截图
            $taskPic = db('TaskPic')->where(['task_id'=>$id])->select();
            $this->assign('info',$info);
            $this->assign('task_pic',$taskPic);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 任务单审核
     */
    public function taskVerify(){
        if(request()->isPost()){
            $reqData = input('param.');
            if(isset($reqData['id']) && !empty($reqData['id'])){
                $ids[] = $reqData['id'];
            }else{
                $ids = $reqData['ids'];
            }
            $taskModel = new taskModel();
            $result = $taskModel->doTaskVerify($ids,$reqData);
            if(isset($result['code']) && $result['code']==200){
                $this->success('审核成功',url('Task/taskList'));
            }
            $this->error($result['msg']);
        }
    }

    /*
     * 任务单撤消
     */
    public function taskCancel(){
        if(request()->isPost()){
            $reqData = input('param.');
            if(isset($reqData['id']) && !empty($reqData['id'])){
                $ids[] = $reqData['id'];
            }else{
                $ids = $reqData['ids'];
            }
            $taskModel = new taskModel();
            $result = $taskModel->doTaskCancel($ids,$reqData);
            if(isset($result['code']) && $result['code']==200){
                $this->success('取消成功',url('Task/taskList'));
            }
            $this->error($result['msg']);
        }
    }
    /*
     * 更新任务订单信息
     */
    public function updateTaskInfo(){
        if(request()->isPost()){
            $reqData = input('param.');
            $taskModel = new taskModel();
            $result = $taskModel->doUpTaskInfo($reqData);
            if(isset($result['code']) && $result['code']==200){
                $this->success('更新商品信息成功');
            }
            $this->error($result['msg']);
        }
    }

    /*
     * 计划审核
     */
    public function createTask(){
        $linkage = linkage('task');
        $admin_id = session('admin_id');
        if(request()->isPost()){
            $reqData = input('param.');
            $taskModel = new taskModel();
            $result = $taskModel->doCreateTask($reqData,$admin_id);
            if(isset($result['code']) && $result['code']!=200){
                $this->error($result['msg']);
            }
            $this->success('操作成功',url('Task/taskList'));
        }
        $this->assign('linkage',$linkage);
        return $this->fetch();
    }
    /*
     * 任务AJAX页面
     */
    public function ajaxPlanList(){
        $admin_id = session('admin_id');
        $reqData = input('param.');
        $taskModel = new taskModel();
        $result = $taskModel->doCreateTask($reqData,$admin_id);
        if(isset($result['code']) && $result['code']!=200){
            $this->error($result['msg']);
        }
        $this->assign('result',$result);
         return $this->fetch();
    }
}