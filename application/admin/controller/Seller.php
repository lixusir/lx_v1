<?php
namespace app\admin\controller;
use app\model\Shop AS shopModel;
use app\model\Recharge AS RechargeModel;
class Seller extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 商家列表
     */
    public function sellerList()
    {
        $linkage = linkage('member')['status'];
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $mobile = input('post.mobile');
            if (!empty($phone)) {
                $where['mobile'] = $mobile;
            }
            $name = input('post.name');
            if (!empty($name)) {
                $where['name'] = ['like', "%" . $name . "%"];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            //显示用户下的商家
            $superior_id = session('admin_id');
            if($superior_id!=1){
                $where['superior_id'] = $superior_id;
            }
            $list = db('Seller')->where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage[$value['status']];
                $value['create_time_text'] = date('Y-m-d H:i:s',$value['create_time']);
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 商家编辑
     */
    public function sellerEdit(){
        $linkage = linkage('member');
        $admin_id = session('admin_id');
        if(request()->isPost()){
             $param = input('param.');
             $data = [
                 'name'=>$param['name'],
                 'real_name'=>$param['real_name'],
                 'mobile'=>$param['mobile'],
                 'bank_name'=>$param['bank_name'],
                 'bank_number'=>$param['bank_number'],
                 'password'=> encrypt($param['password']),
                 'sex'=>$param['sex'],
                 'age'=>$param['age'],
                 'qq'=>$param['qq'],
                 'wechat'=>$param['wechat'],
                 'ship_addr'=>$param['ship_addr'],
                 'superior_id'=>$admin_id,
                 'status'=>$param['status'],
             ];
             $aId = $param['id'];
             if(isset($aId) && !empty($aId)){
                 $data['id'] = $aId;
                 //查找商家
                 $sellers = db('Seller')->where(['superior_id'=>$admin_id,'id'=>$aId])->find();
                 if(!$sellers && $admin_id!=1 ){
                     $this->error('非法操作');
                 }
                 if(empty($param['password'])){
                     unset($data['password']);
                 }
                 $result = db('Seller')->update($data);
             }else{
                 if(empty($param['password'])){
                     $this->error('登录密码必须输入');
                 }
                 $data['create_time'] = time();
                 $result = db('Seller')->insert($data);
             }
             if($result){
                 $this->success('操作成功',url('Seller/sellerList'));
             }
             $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = db('Seller')->where(['id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
            $this->assign('info',$info);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 商家删除
     */
    public function sellerDel(){
        $admin_id = session('admin_id');
        $id = input('param.id');
        $info = db('Seller')->where(['id'=>$id])->find();
        if($info){
            if($info['superior_id'] !=$admin_id && $admin_id!=1){
                $this->error('非法操作');
            }
        }
        $result = db('Seller')->where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
    /*
     * 店铺列表
     */
    public function shopList()
    {
        $linkage = linkage('shop');
        $shopCate = db('ShopCat')->column('id,name');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $name = input('post.name');
            if (isset($name) && $name != '') {
                $where['name'] = ['like','%'.$name.'%'];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $cat_id = input('post.cat_id');
            if (isset($cat_id) && $cat_id != '') {
                $where['cat_id'] = $cat_id;
            }
            //显示用户名下的店铺
            $admin_id = session('admin_id');
            if($admin_id!=1){
                $where['superior_id'] = $admin_id;
            }
            $list = shopModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
                $value['shop_type_text'] = $linkage['shop_type'][$value['shop_type']];
                $value['cate_name'] = $shopCate[$value['cat_id']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        $this->assign('shop_cate',$shopCate);
        return view();
    }
    /*
     * 店铺编辑
     */
    public function shopEdit(){
        $linkage = linkage('shop');
        $admin_id = session('admin_id');
        if(request()->isPost()){
            $param = input('param.');
            $data = [
                'name'=>$param['name'],
                'seller_id'=>$param['seller_id'],
                'superior_id'=>$admin_id,
                'tb_shop_id'=>$param['tb_shop_id'],
                'ww_number'=>$param['ww_number'],
                'shop_type'=>$param['shop_type'],
                'cat_id'=>$param['cat_id'],
                'shop_url'=>$param['shop_url'],
                'daily_limit'=>$param['daily_limit'],
                'remarks'=>$param['remarks'],
                'status'=>$param['status'],
            ];
            $aId = $param['id'];
            if(isset($aId) && !empty($aId)){
                $data['id'] = $aId;
                //查找店铺
                $shops = shopModel::where(['superior_id'=>$admin_id,'id'=>$aId])->find();
                if(!$shops && $admin_id!=1 ){
                    $this->error('非法操作');
                }
                $result = shopModel::update($data);
            }
            if($result){
                $this->success('操作成功',url('Seller/shopList'));
            }
            $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = db('Shop')->where(['id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
            //店铺类目
            $shopCate = db('ShopCat')->select();
            $this->assign('info',$info);
            $this->assign('shop_cate',$shopCate);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }

    /*
     * 充值列表
     */
    public function rechargeList()
    {
        $linkage = linkage('recharge');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $seller_name = input('post.seller_name');
            if (isset($seller_name) && $seller_name != '') {
                $where['seller_name'] = ['like','%'.$seller_name.'%'];
            }
            $time = input('post.time');
            if(isset($time) && !empty($time)){
                $time_arr = explode(' - ',$time);
                $where['create_time'] = ['between time',[$time_arr[0].' 00:00:01',$time_arr[1].' 23:59:59']];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            //显示用户名下的充值记录
            $admin_id = session('admin_id');
            if($admin_id!=1){
                $where['superior_id'] = $admin_id;
            }
            $list = rechargeModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 充值编辑
     */
    public function rechargeEdit(){
        $linkage = linkage('recharge');
        $admin_id = session('admin_id');
        if(request()->isPost()){
            $param = input('param.');
            $rechargeModel = new RechargeModel();
            $result = $rechargeModel->rechargeVerify($param);
            if(isset($result['code']) && $result['code']==200){
                $this->success('操作成功',url('Seller/rechargeList'));
            }
            $errorMsg = isset($result['msg'])?$result['msg']:'操作失败';
            $this->error($errorMsg);
        }else{
            $id = input('get.id/d');
            $info = db('Recharge')->where(['id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
            $this->assign('info',$info);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }

}