<?php
namespace app\seller\controller;
use app\model\Shop AS shopModel;
class Shop extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
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
            $where['seller_id'] = session('seller_id');
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
        $seller_id = session('seller_id');
        $seller_name = session('seller_name');
        $superior_id = session('superior_id');
        //店铺类目
        $shopCate = db('ShopCat')->column('id,name');
        if(request()->isPost()){
            $regData = input('param.');
            //查找商家上级用户ID
            $admins = db('Admin')->where(['id'=>$superior_id])->find();
            if(!$admins){
                $this->error('上级用户不存在');
            }
            $data = [
                'superior_id'=>$superior_id,
                'seller_id'=>$seller_id,
                'seller_name'=>$seller_name,
                'name'=>$regData['name'],
                'tb_shop_id'=>$regData['tb_shop_id'],
                'ww_number'=>$regData['ww_number'],
                'shop_type'=>$regData['shop_type'],
                'cat_id'=>$regData['cat_id'],
                'cat_name'=>$shopCate[$regData['cat_id']],
                'shop_url'=>$regData['shop_url'],
                'status'=> 0,
            ];
            $aId = $regData['id'];
            if(isset($aId) && !empty($aId)){
                $data['id'] = $aId;
                //查找店铺
                $shops = shopModel::where(['seller_id'=>$seller_id,'id'=>$aId])->find();
                if(!$shops){
                    $this->error('非法操作');
                }
                $data['update_time'] = time();
                $result = shopModel::update($data);
            }else{
                $data['create_time'] = time();
                $result = shopModel::create($data);
            }
            if($result){
                $this->success('操作成功',url('Shop/shopList'));
            }
            $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = shopModel::where(['id'=>$id])->find();
            if($info){
                if($info['seller_id'] !=$seller_id){
                    $this->error('非法操作');
                }
            }
            $this->assign('info',$info);
            $this->assign('shop_cate',$shopCate);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }

    /*
     * 店铺删除
     */
    public function shopDel(){
        $id = input('param.id');
        $seller_id = session('seller_id');
        $info = shopModel::where(['seller_id'=>$seller_id,'id'=>$id])->find();
        if(!$info){
            $this->error('未找到店铺');
        }
        $result = shopModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
}