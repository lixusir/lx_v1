<?php
namespace app\model;
use app\model\Account;
use think\Model;
use think\Db;
use app\model\Order as orderModel;
class Plan extends Model{
     /*
      * 计划发布
      */
     public function doAddPlan($tplInfo, $reqData){
         $error = ['code'=>0,'msg'=>'error'];
         $tplId = $tplInfo['id'];
         $superiorId = $tplInfo['superior_id'];
         $superiorName = $tplInfo['superior_name'];
         $sellerId = $tplInfo['seller_id'];
         $shopId = $tplInfo['shop_id'];
         Db::startTrans();
         try {
             $keyword = $reqData['keyword'];
             $beninTime = strtotime($reqData['begin_time']);
             $nameArr = $keyword['name'];
             $skuArr = $keyword['sku'];
             $countArr = $keyword['count'];
             $priceArr = $keyword['goods_price'];
             $numArr = $keyword['goods_num'];
             $orderData = [];
             foreach($nameArr as $key=>$value){
                  //获取计划佣金
                  $goodsPrice = $priceArr[$key] * $numArr[$key];
                  $unitMoney = Account::getSellerCommission($sellerId,$superiorId,$shopId,$goodsPrice);//单计划佣金
                  $unitTotal = $unitMoney * $countArr[$key]; //计划总佣金= 佣金单价* 计划数量
                  //生成计划数据
                 $plan_data = [
                     'seller_id'=>$sellerId,
                     'superior_id'=>$superiorId,//负责人ID
                     'superior_name'=>$superiorName,//负责人名称
                     'shop_id'=>$shopId,
                     'shop_name'=>$tplInfo['shop_name'],
                     'tpl_id'=>$tplId,
                     'keyword'=>$value,
                     'count'=>$countArr[$key],
                     'goods_pic'=>$tplInfo['goods_pic'],
                     'goods_id'=>intval($tplInfo['goods_id']),
                     'goods_name'=>$tplInfo['goods_name'],
                     'goods_price'=>$priceArr[$key],
                     'goods_sku'=>$skuArr[$key],
                     'goods_num'=>$numArr[$key],
                     'total_price'=>$goodsPrice * $countArr[$key],
                     'coupon_price'=>'',
                     'sort_type'=>$tplInfo['sort_type'],
                     'sort_min'=>$tplInfo['sort_min'],
                     'sort_max'=>$tplInfo['sort_max'],
                     'view_time'=>$tplInfo['view_time'],
                     'price_min'=>$tplInfo['price_min'],
                     'price_max'=>$tplInfo['price_max'],
                     'unit_money'=>$unitMoney,//佣金单价
                     'seller_money'=>$unitTotal,//佣金总价
                     'shop_cat_id'=>$tplInfo['shop_cat_id'],//店铺分类ID
                     'shop_cat_name'=>$tplInfo['shop_cat_name'],//店铺分类名称
                     'status'=>'0',
                     'create_time'=>time(),
                     'begin_time'=>$beninTime,
                 ];
//                 dump($plan_data);
                 $plan_id = self::insertGetId($plan_data);
                 //生成订单数据
                 $orderData[] = self::createOrder($plan_data,$plan_id,$tplInfo);

                 //扣除商家佣金
                 $acc_data = [];
                 $acc_data['operate'] = 2;//资金类型 1增加 2减少
                 $acc_data['user_id'] = $sellerId;//操作商家ID
                 $acc_data['user_type'] = 2;//操作用户类型 1业务员 2商家 3管理员
                 $acc_data['amount'] = $unitTotal;//操作金额
                 $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
                 $acc_data['plan_id'] = $plan_id;//计划ID
                 $acc_data['remark'] = '发布计划，扣除佣金[计划编号:'.$plan_id.']';//操作备注
                 $acc_res = Account::doUserAccount($acc_data);
                 if($acc_res['code']!=200){
                     Db::rollback();
                     $error['msg'] = $acc_res['msg'];
                     return $error;
                 }
             }
             $orRes = self::orderRecombination($orderData);
//             dump($orRes);exit;
             $orderModel = new orderModel();
             $res = $orderModel->saveAll($orRes);
             if(!$res){
                 Db::rollback();
                 $error['msg'] = '生成订单失败';
                 return $error;
             }
//             return $res;

             Db::commit();
             return ['code' => 200, 'msg' => '保存成功'];
         } catch (\Exception  $ex) {
             Db::rollback();
             throw $ex;
         }
     }
     /*
      * 订单数据重组
      */
     public function orderRecombination($orderArr){
          $newArr = multi2Array($orderArr);
          $count = count($newArr);
          $orderCity = self::createOrderCity($count);
         $resArr = [];
         foreach ($newArr as $key => &$value) {
             $value['city']= $orderCity[$key];
             $resArr[] = $value;
         }
          return $resArr;
     }
    /*
     * 生成接单城市
     */
    public function createOrderCity($count){
        $u_map = [
            'status'=>1,
            'is_back'=>0,
        ];
        $userCitys = db('Users')->field('city, count(id)*sum(max_task) as tnum')->where($u_map)->group('city')->select();
        //获取系统配置
        $config = db('SystemConfig')->find(1);
        $unite = $config['task_unite'];
//        dump($userCitys);exit;
        $city_res = [];
        if(count($userCitys)>0){
            foreach($userCitys as $key=> $value){
                $city = $value['city'];
                $tnum = $value['tnum'];
                $taskNum = $unite*$tnum;//基数 = 合一数 * 用户数量 * 用户最大接单量
                //城市接单量
                $cityTask = orderModel::where(['city'=>$city,'status'=>['IN',[0,1]]])->whereTime('create_time','today')->count();
                if($cityTask<$taskNum){
                    $city_res[] = $city;
                }
            }
        }
//        dump($city_res);exit;
//        dump(array_rand($city_res));exit;
        $userCount = count($city_res);
        if($userCount<$count){
            $ss = $count-$userCount;
            $maxU = $userCount-1;
//            dump($rand);
//            dump($city_res[$rand]);
            for($i=0;$i<$ss;$i++){
                $rand = rand(0,$maxU);
                $city_res[] = $city_res[$rand];
            }
        }
        return $city_res;
        dump($city_res);exit;
    }
     /*
      * 生成订单
      */
     public function createOrder($regData,$plan_id,$tplInfo){
         //获取刷手佣金
         $gain_money = Account::getUserCommission($regData['total_price']);
         //获取计划数量
         $count = $regData['count'];
         $data = [
             'plan_id'=>$plan_id,
             'shop_name'=>$regData['shop_name'],
             'shop_id'=>$regData['shop_id'],
             'goods_id'=>$regData['goods_id'],
             'goods_name'=>$regData['goods_name'],
             'goods_num'=>$regData['goods_num'],
             'goods_sku'=>$regData['goods_sku'],
             'goods_pic'=>$regData['goods_pic'],
             'seller_id'=>$regData['seller_id'],
             'superior_id'=>$regData['superior_id'],
             'money'=>$regData['goods_price']*$regData['goods_num'],
             'down_price'=>$regData['goods_price']*$regData['goods_num'],
             'keyword'=>$regData['keyword'],
             'gain_money'=>$gain_money,
             'status'=>'0',
             'create_time'=>time(),
         ];
         $order_data = [];
         for($i=0;$i<$count;$i++){
             $order_data[] = $data;
         }
         return $order_data;
         dump($order_data);exit;
     }

     /*
      * 取消计划
      */
     public function doCancelPlan($ids,$sellerId=0,$adminId=false){
         $error = ['code'=>0,'msg'=>'error'];
         Db::startTrans();
         try{
             if(!is_array($ids) || count($ids)<=0){
                 $error['msg'] = 'IDS错误';
                 return $error;
             }
             $remarks = '';
             if($adminId){
                 $map = [
                     'id'=>['IN',$ids]
                 ];
             }else{
                 if(empty($sellerId)){
                     $error['msg'] = '商家ID不能为空';
                     return $error;
                 }
                 $map = [
                     'seller_id'=>$sellerId,
                     'id'=>['IN',$ids]
                 ];
             }

             $res = self::field('id,seller_id,unit_money,seller_money,status')->where($map)->select();
             if(empty($res)){
                 $error['msg'] = '无计划可取消';
                 return $error;
             }
             foreach($res as $key=>$value){
                 if($value['status']!=0 && $value['status']!=1){
                     $error['msg'] = '计划ID:'.$value['id'].'，状态不是待审或已审，无法取消';
                     return $error;
                 }
             }
             //执行取消流程
             $planIds = [];
             foreach($res as $key=>$value){
                 if($value['status']==0 || $value['status']==1){
                     $planIds[]=$value['id'];
                     //退还佣金
                     $unitTotal = $value['seller_money'];
                     $acc_data = [];
                     $acc_data['operate'] = 1;//资金类型 1增加 2减少
                     $acc_data['user_id'] = $value['seller_id'];//操作商家ID
                     $acc_data['user_type'] = 2;//操作用户类型 1业务员 2商家 3管理员
                     $acc_data['amount'] = $unitTotal;//操作金额
                     $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
                     $acc_data['plan_id'] = $value['id'];//计划ID
                     $acc_data['remark'] = '取消计划，退还佣金[计划编号:'.$value['id'].']';//操作备注
                     $acc_res = Account::doUserAccount($acc_data);
                     if($acc_res['code']!=200){
                         Db::rollback();
                         $error['msg'] = $acc_res['msg'];
                         return $error;
                     }
                 }
             }
             //更新计划状态
             $up_data =[
                 'remarks'=>$remarks,//操作备注
                 'status'=>5,//已撤消
                 'cancel_time'=>time(),//撤消时间
             ];
             $up_plan = self::where(['id'=>['IN',$planIds]])->update($up_data);
             if(!$up_plan){
                 Db::rollback();
                 $error['msg'] = '更新计划状态失败';
                 return $error;
             }
             //删除计划订单
             $del_order = orderModel::where(['plan_id'=>['IN',$planIds]])->delete();
             if(!$del_order){
                 Db::rollback();
                 $error['msg'] = '更新订单状态失败';
                 return $error;
             }
             Db::commit();
             return ['code'=>200,'msg'=>'成功'];
         }catch(\Exception $e){
             Db::rollback();
             throw $e;
         }

     }
     /*
      * 计划审核
      */
     public function doVerifyPlan($ids,$regData){
         $error = ['code'=>0,'msg'=>'error'];
         Db::startTrans();
         try{
             $adminId = session('admin_id');
             $map = [
//                 'status'=>0,
                 'id'=>['IN',$ids],
             ];
             if($adminId!=1){
                 $map['superior_id'] = $adminId;
             }
             $res = self::field('id,seller_id,unit_money,seller_money,status')->where($map)->select();
             if(count($res)<=0){
                 $error['msg'] = '无计划可审核';
                 return $error;
             }
             foreach($res as $key=>$value){
                 if($value['status']!=0){
                     $error['msg'] = '计划ID:'.$value['id'].'，状态不是待审，无法审核！';
                     return $error;
                 }
             }
             if (!isset($regData['sub_type']) || !in_array($regData['sub_type'],[1,4])) {
                 $error['msg'] = '审核类型错误';
                 return $error;
             }
             $subType = $regData['sub_type'];
             $up_data = [];
             $planIds = [];
             foreach($res as $value){
                 if($subType==1){
                     //审核通过
                     $up_data[] = [
                         'id'=>$value['id'],
                         'status'=>1,
                         'verify_time'=>time(),
                     ];
                 }elseif($subType==4){
                     //审核不通过
                     $up_data[] = [
                         'id'=>$value['id'],
                         'status'=>4,
                         'remarks'=>$regData['remarks'],
                         'verify_time'=>time(),
                     ];
                     //删除订单
                     $planIds[] = $value['id'];
                     //退还佣金
                     $unitTotal = $value['seller_money'];
                     $acc_data = [];
                     $acc_data['operate'] = 1;//资金类型 1增加 2减少
                     $acc_data['user_id'] = $value['seller_id'];//操作商家ID
                     $acc_data['user_type'] = 2;//操作用户类型 1业务员 2商家 3管理员
                     $acc_data['amount'] = $unitTotal;//操作金额
                     $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
                     $acc_data['plan_id'] = $value['id'];//计划ID
                     $acc_data['remark'] = '计划未通过审核，退还佣金[计划编号:'.$value['id'].']';//操作备注
                     $acc_res = Account::doUserAccount($acc_data);
                     if($acc_res['code']!=200){
                         Db::rollback();
                         $error['msg'] = $acc_res['msg'];
                         return $error;
                     }
                 }
             }
             //更新计划
             $result = self::saveAll($up_data);
             if(!$result){
                 Db::rollback();
                 $error['msg'] = '更新计划失败';
                 return $error;
             }
             //删除订单
             if(count($planIds)>0){
                 $del_order = orderModel::where(['plan_id'=>['IN',$planIds]])->delete();
                 if(!$del_order){
                     Db::rollback();
                     $error['msg'] = '删除订单失败';
                     return $error;
                 }
             }
             Db::commit();
             return ['code'=>200,'msg'=>'成功'];
         }catch(\Exception $e){
             Db::rollback();
             throw $e;
         }


     }
}
