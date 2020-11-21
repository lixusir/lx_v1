<?php
namespace app\admin\controller;
use app\model\Plan as planModel;
use app\admin\model\Admin as adminModel;
class Plan extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 计划列表
     */
    public function planList()
    {
        $linkage = linkage('plan');
        $admin_id = session('admin_id');
        $type = input('param.type',1);
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            if($admin_id!=1){
                $where['superior_id'] = $admin_id;
            }
            if($type==1){
                $s_time = date('Y-m-d 00:00:00',time());
                $e_time = date('Y-m-d 23:59:59',time());
                $where['create_time'] = ['between time',[$s_time,$e_time]];
            }elseif($type==3){
                $where['status'] = '0';
            }
            $goods_name = input('post.goods_name');
            if (isset($goods_name) && $goods_name != '') {
                $where['goods_name'] = ['like','%'.$goods_name.'%'];
            }
            $goods_id = input('post.goods_id');
            if (isset($goods_id) && $goods_id != '') {
                $where['goods_id'] = $goods_id;
            }
            $keyword = input('post.keyword');
            if (isset($keyword) && $keyword != '') {
                $where['keyword'] = ['like','%'.$keyword.'%'];
            }
            $shop_name = input('post.shop_name');
            if (isset($shop_name) && $shop_name != '') {
                $where['shop_name'] = $shop_name;
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $list = planModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach ($list['data'] as &$val){
                $val['status_text']=$linkage['status'][$val['status']];
                $val['begin_time_text']= date('Y-m-d',$val['begin_time']);
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
    public function planEdit(){
        $linkage = linkage('plan');
        $admin_id = session('admin_id');
        $id = input('get.id/d');
        $map['id'] = $id;
        if($admin_id!=1){
            $map['superior_id'] = $admin_id;
        }
        $info = planModel::where($map)->find();
        if(!$info){
            $this->error('计划不存在');
        }
        if($info['superior_id'] !=$admin_id && $admin_id!=1){
            $this->error('非法操作');
        }
        $this->assign('info',$info);
        $this->assign('linkage',$linkage);
        return $this->fetch();
    }
    /*
     * 计划审核
     */
    public function planVerify(){
        $reqData = input('param.');
        if (!isset($reqData['sub_type']) || !in_array($reqData['sub_type'],[1,4])) {
            $this->error('审核类型错误');
        }
        if (isset($reqData['ids']) && is_array($reqData['ids'])) {
            $ids = $reqData['ids'];
        }else{
            $ids = [$reqData['id']];
        }
        $planModel = new planModel();
        $result = $planModel->doVerifyPlan($ids,$reqData);
        if(isset($result['code']) && $result['code']!=200){
            $this->error($result['msg']);
        }
        $this->success('操作成功',url('Plan/planList'));
    }

    /*
     * 计划取消
     */
    public function planCancel(){
        $reqData = input('param.');
        if (isset($reqData['ids']) && is_array($reqData['ids'])) {
            $ids = $reqData['ids'];
        }else{
            $ids = [$reqData['id']];
        }
        $planModel = new planModel();
        $result = $planModel->doCancelPlan($ids,0,true);
        if(isset($result['code']) && $result['code']!=200){
            $this->error($result['msg']);
        }
        $this->success('操作成功',url('Plan/planList'));
    }
    /*
     * 计划统计
     */
    public function planTotal()
    {
        $linkage = linkage('plan');
        $admin_id = session('admin_id');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $admin_name = input('post.admin_name');
            if (isset($admin_name) && $admin_name != '') {
                $where['user_name'] = $admin_name;
            }
            $where['status'] = 1;
            $list = adminModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach ($list['data'] as &$val){
                $val['admin_name'] = $val['user_name'];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }



}