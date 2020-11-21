<?php
namespace app\admin\controller;
use app\admin\model\SystemRule as ruleModel;
use app\admin\model\SystemConfig as configModel;
use app\admin\model\ShopCat as shopCatModel;
use app\admin\model\Commission;
class System extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 系统设置
     */
    public function configEdit(){
        $linkage = linkage('system');
        if(request()->isPost()){
            $reqData = input('param.');
            $data = [
                'edit_name_time'=>$reqData['edit_name_time'],
                'template'=>$reqData['template'],
                'task_max_money'=>$reqData['task_max_money'],
                'task_unite'=>$reqData['task_unite'],
                'is_goods_code'=>!empty($reqData['is_goods_code']) ? 1 : 0,
                'month_cash_num'=>$reqData['month_cash_num'],
                'day_cash_num'=>$reqData['day_cash_num'],
                'is_invite'=>!empty($reqData['is_invite']) ? 1 : 0,
                'invite_time'=>$reqData['invite_time'],
            ];
            $result = configModel::where(['id'=>1])->update($data);
            if($result){
                $this->success('操作成功',url('Message/msgList'));
            }
            $this->error('操作失败');
        }else{
            $info = configModel::where(['id'=>1])->find();
            $this->assign('info',$info);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 佣金规则
     */
    public function Commission(){
        $adminId = session('admin_id');
        $superiorId = session('superior_id');
        $topId = $adminId;
        //用户上级非超级管理员，查询用户上级佣金
        if($superiorId!=1 && $adminId!=1){
            $topId = $superiorId;
        }
        if(request()->isPost()){
            $reqData = input('post.');
//            dump($reqData);exit;
            if (!empty($reqData['comm'])) {
                foreach ($reqData['comm'] as $key => $val) {
                    if (!empty($val)) {
                        //判断是否非法操作
                        $commRes = Commission::where(['id'=>$key,'superior_id'=>$topId])->find();
                        if($commRes){
                            $data[] = [
                                'id' => $key,
                                'val' => floatval($val),
                            ];
                        }
                    }
                }
            }
            if (!empty($data)) {
                $comModel = new Commission();
                $comModel->isUpdate()->saveAll($data);
            }
            if($adminId==1){
                $data = [
                    'user_comment_money' => $reqData['user_comment_money'],
                    'seller_comment_money' => $reqData['seller_comment_money'],
                ];
                db('SystemConfig')->where(['id'=>1])->update($data);
            }
            $this->success('操作成功');
        }else{
            $map = [
                'superior_id'=>$topId
            ];
            $commission = db('Commission')->where($map)->order('sort desc')->select();
            $newList = [];
            foreach ($commission as $value) {
                $newList[$value['type_id']][] = $value;
            }
            $config = db('SystemConfig')->where(['id'=>1])->find();;
            $this->assign('commission',$newList);
            $this->assign('config',$config);
            return $this->fetch();
        }
    }
    /*
     * 店铺类别
     */
    public function shopCate(){
        if(request()->isPost()){
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $catName = input('post.cat_name');
            if (!empty($catName)) {
                $where['name'] = ['like', "%" . $catName . "%"];
            }
            $list = shopCatModel::where($where)->paginate($pageSize)->toArray();
            foreach ($list['data'] as &$value) {
                $value['day_num'] = !empty($value['day_num']) ? $value['day_num'] : '';
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }else{
            return $this->fetch();
        }
    }
    /*
     * 修改店铺类别天数限制
     */
    public function upCatDayNum()
    {
        $catId = input('post.id');
        $dayNum = input('post.day_num/d');
        $upData = [
            'day_num' => $dayNum,
        ];
        $res = shopCatModel::update($upData, ['id' => $catId]);
        if (!$res) {
            $this->error('修改失败');
        }
        $this->success('修改成功');
    }
   /*
    * 权限规则列表
    */
    public function ruleList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $catId = input('post.cat_id');
            if (!empty($catId)) {
                $where['cat_id'] = $catId;
            }
            $shopName = input('post.shop_name');
            if (!empty($shopName)) {
                $where['name'] = ['like', "%" . $shopName . "%"];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $list = ruleModel::where($where)->order('sort desc')->paginate($pageSize)->toArray();
            $list['data'] = getTree($list['data']);
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
    /*
    * 权限规则编辑
    */
    public function ruleEdit(){
        $linkage = linkage('rule');
        if(request()->isPost()){
            $reqData = input('param.');
             $validate = validate('RuleEdit');
             if(!$validate->check($reqData)){
                  $this->error($validate->getError());
             }
             $data = [
                 'pid'=>!empty($reqData['pid'])?$reqData['pid']:0,
                 'name'=>$reqData['name'],
                 'type'=>$reqData['type'],
                 'icon'=>$reqData['icon'],
                 'link'=>$reqData['link'],
                 'sort'=>$reqData['sort'],
                 'status'=>$reqData['status'],
                 'spread'=>$reqData['spread'],
             ];
             $ruleId = $reqData['id'];
             if(isset($ruleId) && !empty($ruleId)){
                 $data['id'] = $ruleId;
                 $result = ruleModel::update($data);
             }else{
                 $data['create_time'] = time();
                 $result = ruleModel::create($data);
             }
             if($result){
                 $this->success('操作成功',url('System/ruleList'));
             }
             $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = ruleModel::where(['id'=>$id])->find();
            //规则列表
            $rule = db('SystemRule')->order('sort desc')->select();
            $rule = getTree($rule);
            $this->assign('info',$info);
            $this->assign('rule',$rule);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
    * 权限规则删除
    */
    public function ruleDel(){
        $id = input('param.id');
        $info = ruleModel::where(['id'=>$id])->find();
        if(!$info){
            $this->error('非法操作');
        }
        $result = ruleModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');
    }
}