<?php

namespace app\api\controller;

use app\model\Task as taskModel;

class Task extends ApiBase
{
    /*
     * 获取任务列表
     */
    public function getTaskList()
    {
        $linkage = linkage('task');
        $uid = getTokenVar('uid');
        $page = input('param.page');
        $perPage = input('param.per_page', 10);
        $tabIndex = input('param.tab_index',1);
        $where = [];
        $where['user_id'] = $uid;
        if($tabIndex==1){
            $where['status'] = ['IN',[1,2]];
        }elseif($tabIndex==2){
            $where['status'] = 4;
        }
//        dump($where);exit;
        $result = taskModel::with(['order','pic'])->where($where)->paginate($perPage, false, ['page' => $page])->toArray();
        foreach ($result['data'] as &$value){
            $value['status_text']=$linkage['status'][$value['status']];
            //任务主图
            $value['task_pic'] = isset($value['pic'][0]['pic'])?getImgUrl($value['pic'][0]['pic']):getImgUrl('/static/images/no_image.gif');
        }
        $data = [
            'pageCount' => $perPage,
            'currPage' => $result['current_page'],
            'perPage' => $result['per_page'],
            'totalCount' => $result['total'],
            'list' => $result['data']
        ];
        reSuccess('成功', $data);
    }
    /*
     * 获取任务详情
     */
    public function getTaskView(){
        $linkage = linkage('task');
        $uid = getTokenVar('uid');
        $id = input('get.id/d');
        $info = taskModel::with('order')->where(['id'=>$id])->find()->toArray();
        if($info){
            if($info['user_id'] !=$uid){
                reError('非法操作');
            }
        }
//        dump($info);exit;
        if(isset($info['order']) && count($info['order'])>0){
            foreach($info['order'] as &$value){
                $value['goods_pic'] = getImgUrl($value['goods_pic']);
            }
        }
        $info['status_text'] = $linkage['status'][$info['status']];
        $taskPic = db('TaskPic')->where(['task_id'=>$id])->select();
        if(count($taskPic)>0){
            foreach($taskPic as &$value){
                $value['pic'] = getImgUrl($value['pic']);
            }
        }
        $info['task_pic'] = $taskPic;
        $info['pic_count'] = count($taskPic);
        reSuccess('成功', $info);
    }
    /*
     * 获取任务订单详情
     */
    public function getOrderView(){
        $linkage = linkage('task');
        $id = input('get.id/d');
        $info = db('Order')->where(['id'=>$id])->find();
        if(!$info){
            reError('订单不存在');
        }
        $plan = db('Plan')->where(['id'=>$info['plan_id']])->find();
        if(!$plan){
            reError('订单计划不存在');
        }
        $info['goods_pic'] = getImgUrl($info['goods_pic']);
        $result['order'] = $info;
        if($plan['price_max']>0){
            $price_range = $plan['price_min'].'~'.$plan['price_max'];
        }
        $result['plan'] = [
            "sort_type"=> !empty($plan['sort_type'])?$linkage['sort_type'][$plan['sort_type']]:$linkage['sort_type'][1],
            "sort_min"=>$plan['sort_min'],
            "sort_max"=>$plan['sort_max'],
            "view_time"=> !empty($plan['view_time'])?$linkage['view_time'][$plan['view_time']]:'不限',
            "price_min"=>$plan['price_min'],
            "price_max"=>$plan['price_max'],
            "other_remark"=>$plan['other_remark'],
            "price_range"=>!empty($price_range)?$price_range:'',
        ];
        reSuccess('成功', $result);
    }
    /*
     * 任务单提交
     */
    public function subTaskOrder(){
        $regData = input('param.');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录，请登录');
        }
        $taskModel = new taskModel();
        $result = $taskModel->doSubTaskOrder($regData,$uid);
        if(isset($result['code']) && $result['code']==200){
            reSuccess('提交成功');
        }
        reError($result['msg']);
    }
    /*
    * 更新任务订单信息
    */
    public function updateOrderInfo(){
        $regData = input('param.');
//        dump($regData);exit;
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录，请登录');
        }
        if(!isset($regData['id']) || empty($regData['id'])){
            reError('缺少参数');
        }
        $id = $regData['id'];
        $info = db('Order')->where(['id'=>$id])->find();
        if(!$info){
            reError('订单不存在');
        }
        $task = db('Task')->where(['id'=>$info['task_id']])->find();
        if(!$task){
            reError('订单任务不存在');
        }
        if($task['user_id'] !=$uid){
            reError('非法操作');
        }
        $update = [];
        if(isset($regData['down_price']) && !empty($regData['down_price']) && $regData['down_price']!='undefined'){
            $update['down_price'] = $regData['down_price'];
        }
        if(isset($regData['tb_user']) && !empty($regData['tb_user']) && $regData['tb_user']!='undefined'){
            $update['tb_user'] = $regData['tb_user'];
        }
        if(isset($regData['tb_order_sn']) && !empty($regData['tb_order_sn']) && $regData['tb_order_sn']!='undefined'){
            $update['tb_order_sn'] = $regData['tb_order_sn'];
        }
        if(isset($regData['remark']) && !empty($regData['remark']) && $regData['remark']!='undefined'){
            $update['remark'] = $regData['remark'];
        }
        if(count($update)<=0){
            reError('无数据更新');
        }
        $res = db('Order')->where(['id'=>$id])->update($update);
        if(!$res){
            reError('更新失败，请重试');
        }
        reSuccess('更新成功');
    }
}
