<?php
namespace app\seller\model;
use think\Model;
use think\Db;
use app\seller\model\TplKeyword;
class Tpl extends Model{
     /*
      * 新增编辑商品
      */
     public function saveTpl($reqData,$sellerId){
         $tplId = $reqData['tpl_id'];
         Db::startTrans();
         try {
             $superior_id = session('superior_id');
             $superior = db('Admin')->where(['id'=>$superior_id])->find();
             $data = [
                 'seller_id' => $sellerId,
                 'superior_id' => $superior_id,
                 'superior_name' => $superior['user_name'],
                 'shop_id' => $reqData['shop_id'],
                 'shop_name' => $reqData['shop_name'],
                 'shop_cat_id' => !empty($reqData['shop_cat_id'])?$reqData['shop_cat_id']:'',
                 'shop_cat_name' => !empty($reqData['shop_cat_name'])?$reqData['shop_cat_name']:'',
                 'goods_url' => isset($reqData['goods_url'])?$reqData['goods_url']:'',
                 'goods_pic' => $reqData['goods_pic'],
                 'goods_thumb' => $reqData['goods_thumb'],
                 'goods_id' => $reqData['goods_id'],
                 'goods_name' => $reqData['goods_name'],
                 'goods_price' => $reqData['goods_price'],
                 'keyword' => $reqData['keyword'],
                 'sort_type' => $reqData['sort_type'],
                 'sort_min' => $reqData['sort_min'],
                 'sort_max' => $reqData['sort_max'],
//                 'address' => $reqData['address'],
                 'province' => isset($reqData['province'])?$reqData['province']:'0',
                 'city' => isset($reqData['city'])?$reqData['city']:'0',
                 'price_min' => $reqData['price_min'],
                 'price_max' => $reqData['price_max'],
                 'view_time' => $reqData['view_time'],
                 'remarks' => $reqData['remarks'],
             ];
             if (!$tplId || (isset($reqData['copy']) && $reqData['copy']==1)) {
                 $data['create_time'] = time();
                 $res = self::create($data);
                 $tplId = $res->id;
             } else {
                 $data['id'] = $tplId;
                 $data['update_time'] = time();
                 self::update($data);
             }
             //关键字搜索处理
             $keyModel = new TplKeyword();
             $keyModel->where(['tpl_id' => $tplId])->delete();
             if (!empty($reqData['keyword'])) {
                 $keywords = $reqData['keyword'];
                 foreach ($keywords as $key => $val) {
                     $keyArr[] = [
                         'tpl_id' => $tplId,
                         'name' => $val,
                         'create_time' => time(),
                     ];
                 }
                 if (!empty($keyArr)) {
                     $keyModel->saveAll($keyArr);
                 }
             }
             Db::commit();
             return ['code' => 200, 'msg' => '保存成功', 'url' => url('Tpl/index')];
         } catch (\Exception  $ex) {
             Db::rollback();
             throw $ex;
         }
     }
}
