<?php
namespace app\seller\controller;
use app\seller\model\Tpl AS tplModel;
use app\model\Plan AS planModel;
class Plan extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 计划列表
     */
    public function planList()
    {
        $type = input('get.type',1);
        $linkage = linkage('plan');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['seller_id'] = session('seller_id');
            if($type==2){
                $where['status'] = 1;
            }elseif($type==3){
                $where['status'] = 2;
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
            foreach($list['data'] as $key=>&$value){
                $value['status_text'] = $linkage['status'][$value['status']];
                $value['begin_time_text'] = date('Y-m-d',$value['begin_time']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('type',$type);
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 发布计划
     */
    public function planAdd(){
        $linkage = linkage('tpl');
        $seller_id = session('seller_id');
        if(request()->isPost()){
            $reqData = input('param.');
            $tplInfo = tplModel::where(['id'=>$reqData['id']])->find();
            if(!$tplInfo){
                $this->error('模板不存在');
            }
            if (!isset($reqData['keyword']['name']) || empty($reqData['keyword']['name'])) {
                $this->error('商品关键字不能为空');
            }
            $planModel = new planModel();
            $result = $planModel->doAddPlan($tplInfo, $reqData);
            if(isset($result['code']) && $result['code']!=200){
                $this->error($result['msg']);
            }
            $this->success('操作成功',url('Tpl/tplList'));

        }else{
            $id = input('get.id/d');
            $info = tplModel::where(['id'=>$id])->find();
            if($info){
                if($info['seller_id'] !=$seller_id){
                    $this->error('非法操作');
                }
            }
            //模板关键字
            $word = db('TplKeyword')->where(['tpl_id'=>$id])->column('id,name');
            $this->assign('info',$info);
            $this->assign('word',$word);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    public function planView(){
        $linkage = linkage('plan');
        $seller_id = session('seller_id');
        $id = input('get.id/d');
        $map['id'] = $id;
        $map['seller_id'] = $seller_id;
        $info = planModel::where($map)->find();
        if(!$info){
            $this->error('计划不存在');
        }
        $this->assign('info',$info);
        $this->assign('linkage',$linkage);
        return $this->fetch();
    }

    /*
     * 取消计划
     */
    public function planCancel(){
        $ids = input('param.ids/a');
        $seller_id = session('seller_id');
        $planModel = new planModel();
        $result = $planModel->doCancelPlan($ids,$seller_id);
        if(isset($result['code']) && $result['code']!=200){
            $this->error($result['msg']);
        }
        $this->success('操作成功',url('Plan/planList'));
    }
}