<?php
namespace app\seller\controller;
use app\model\Shop AS shopModel;
use app\seller\model\Tpl AS tplModel;
class Tpl extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 模板列表
     */
    public function tplList()
    {
        $linkage = linkage('shop');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['seller_id'] = session('seller_id');
            $goods_name = input('post.goods_name');
            if (isset($goods_name) && $goods_name != '') {
                $where['goods_name'] = ['like','%'.$goods_name.'%'];
            }
            $shop_name = input('post.shop_name');
            if (isset($shop_name) && $shop_name != '') {
                $where['shop_name'] = $shop_name;
            }
            $list = tplModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 模板编辑
     */
    public function tplEdit(){
        $linkage = linkage('tpl');
        $seller_id = session('seller_id');
        //店铺列表
        $shops = shopModel::where(['seller_id'=>$seller_id,'status'=>1])->column('id,name,cat_id,cat_name');
//        dump($shops);exit;
        if(request()->isPost()){
            $reqData = input('param.');
            if(!isset($reqData['keyword']) || empty($reqData['keyword'])){
                $this->error('搜索关键字不能为空');
            }
            $reqData['shop_name'] = $shops[$reqData['shop_id']]['name'];
            $reqData['shop_cat_id'] = $shops[$reqData['shop_id']]['cat_id'];
            $reqData['shop_cat_name'] = $shops[$reqData['shop_id']]['cat_name'];
            $tplModel = new tplModel();
            $result = $tplModel->saveTpl($reqData, $seller_id);
            if($result){
                $this->success('操作成功',url('Tpl/tplList'));
            }
            $this->error('操作失败');
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
            //省份
            $provinces = db('provinces')->select();
            //城市
            $cities = [];
            if(isset($info['province']) && $info['province']>1){
                $cities = db('cities')->where(['provinceid'=>$info['province']])->select();
            }
            $this->assign('info',$info);
            $this->assign('provinces', $provinces);
            $this->assign('cities', $cities);
            $this->assign('word',$word);
            $this->assign('shops',$shops);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }

    /*
     * 模板删除
     */
    public function tplDel(){
        $id = input('param.id');
        $seller_id = session('seller_id');
        $info = tplModel::where(['seller_id'=>$seller_id,'id'=>$id])->find();
        if(!$info){
            $this->error('未找到模板');
        }
        $result = tplModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');
    }
}