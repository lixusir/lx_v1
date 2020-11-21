<?php

namespace app\model;

use think\Model;
use app\model\Users;
use app\model\Order;
use app\model\Plan;
use app\model\Account;
use think\Db;
class Task extends Model
{
    public function order()
    {
        return $this->hasMany('Order', 'task_id', 'id');
    }
    public function pic()
    {
        return $this->hasMany('TaskPic', 'task_id', 'id');
    }
    /*
     * 生成任务单
     */
    public function doCreateTask($unite)
    {
        Db::startTrans();
        try{
            $error = ['code' => 0, 'msg' => 'error'];
            if (!isset($unite) || empty($unite)) {
                $error['msg'] = '几合一不能为空';
                return $error;
            }
            //查找符合要求的计划
            $map = [];
            $map['status'] = ['IN',[1,2]];
            $planIds = db('Plan')->where($map)->whereTime('begin_time','today')->column('id');
            if(count($planIds)<=0){
                $error['msg'] = '无计划可生成';
                return $error;
            }
            //查找待分配订单
            $where = [
                'plan_id'=>['IN',$planIds],
                'status'=>0,
            ];
            $order = db('Order')->field('id,plan_id,shop_id,seller_id,superior_id,money,city,gain_money')->where($where)->select();
            if(count($order)<=0){
                $error['msg'] = '无计划订单可分派';
                return $error;
            }
            //获取合一订单数组
            $orderArr = getUniteOrder($order,$unite);
//            dump($orderArr);exit;
            //任务重组
            if(!is_array($orderArr) || count($orderArr)<=0){
                $error['msg'] = '无计划订单可分派';
                return $error;
            }
            //查找业务员分配任务
            $userRes = self::getTaskUsers();
            $taskIds = [];
            foreach($userRes as $key=>$value){
                $uCity = $value['city'];
                $orderInfo = self::getTaskOrder($orderArr,$uCity);
                if(is_array($orderInfo) && isset($orderInfo['data']) && count($orderInfo['data'])>0){
                    $taskArr = [];
                    $taskArr['task_sn'] = createTaskSn();
                    $taskArr['user_id'] = $value['id'];
                    $taskArr['user_name'] = $value['real_name'];
                    $taskArr['superior_id'] = $value['superior_id'];//负责人ID
                    $taskArr['superior_name'] = $value['superior_name'];//负责人名称
                    $taskArr['tuan_user_id'] = $value['id'];//团队负责人ID
                    $taskArr['tuan_user_name'] = $value['real_name'];//团队负责人名称
                    //团队负责人
                    if($value['user_type']==1){
                        //是否有上级团长
                        if(!empty($value['first_leader'])){
                            $tuanRes = db('Users')->field('id,real_name')->where(['id'=>$value['first_leader']])->find();
                            if($tuanRes){
                                $taskArr['tuan_user_id'] = $tuanRes['id'];
                                $taskArr['tuan_user_name'] = $tuanRes['real_name'];
                            }
                        }
                    }
                    $goods = $orderInfo['data'];//商品数组
                    $orderArr = $orderInfo['diff'];//剩余商品数组
                    $priceTotal = 0;//商品金额统计
                    $gainTotal = 0;//商品佣金统计
                    $orderIds = [];//订单分配IDS
                    $planIds = [];//计划IDS
                    foreach($goods as $value){
                        $priceTotal += $value['money'];
                        $gainTotal += $value['gain_money'];
                        $orderIds[] = $value['id'];
                        $planIds[]=$value['plan_id'];
                    }
                    $taskArr['total_price'] = $priceTotal;
                    $taskArr['down_price'] = $priceTotal;
                    $taskArr['gain_money_total'] = $gainTotal;
                    $taskArr['actual_money_total'] = $gainTotal;
                    $taskArr['city'] = $orderInfo['city'];
                    $taskArr['create_time'] = time();
                    $taskArr['status'] = 1;
                    //保存任务单
                    $taskId = self::insertGetId($taskArr);
                    if(!$taskId){
                        Db::rollback();
                        $error['msg'] = '任务单入库失败';
                        return $error;
                    }
                    //更新订单状态
                    $o_up = [];
                    $o_up['status'] = 1;
                    $o_up['task_id'] = $taskId;
                    $omap['id'] = ['IN',$orderIds];
                    $orderRes = Order::where($omap)->update($o_up);
                    if(!$orderRes){
                        Db::rollback();
                        $error['msg'] = '更新订单状态失败';
                        return $error;
                    }
                    //更新计划状态
                    $planIds = array_unique($planIds);
                    $p_up = [];
                    $p_up['status'] = 2;
                    $p_up['update_time'] = time();
                    $p_map['id'] = ['IN',$planIds];
                    $planRes = Plan::where($p_map)->update($p_up);
                    if(!$planRes){
                        //由于计划要多次更新，此处不判断
//                        Db::rollback();
//                        $error['msg'] = '更新计划状态失败';
//                        return $error;
                    }
                    $taskIds[] = $taskId;
                    Db::commit();
                }else{
                    continue;
                }
            }
            return ['code'=>200,'msg'=>'成功','data'=>$taskIds];
        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }
    /*
     * 分配地区任务
     */
    public function getTaskOrder($orderArr,$uCity){
        $result = [];
        if(isset($orderArr[$uCity]) && count($orderArr[$uCity])>0){
            //存在地区任务
            $city = $uCity;
            $cOrder = $orderArr[$city];
        }elseif(count($orderArr)>0){
            //不存在地区任务
            $city = array_rand($orderArr);
            $cOrder = $orderArr[$city];
        }else{
            return false;
        }
        if(is_array($cOrder) && count($cOrder)<=0){
            return false;
        }
        $order = self::getArrayRands($cOrder,1);
        //去除已分配订单
        unset($cOrder[$order['key']]);
        $orderArr[$city] = $cOrder;
        $result['data'] = $order['data'][$order['key']];//抽取任务
        $result['diff'] = $orderArr;//剩余任务
        $result['city'] = $city;//任务区域
        return $result;
    }
        /*
     * 取二维随机数组
     */
    public function getArrayRands($unique_arr,$unite){
        $keyArr = array_rand($unique_arr,$unite);
        $uArr = [];
        if(is_array($keyArr) && count($keyArr)>0){
            foreach($keyArr as $value){
                $uArr['data'][$value] = $unique_arr[$value];
            }
        }else{
            //随机数为1不必循环
            $uArr['key'] = $keyArr;
            $uArr['data'][$keyArr] = $unique_arr[$keyArr];
        }
        return $uArr;
    }
    /*
     * 查找符合要求的用户
     */
    public function getTaskUsers(){
        $u_map =[
            'status'=>1,
            'is_back'=>0,
        ];
        $user = Users::withCount(['task'=>function($query){
            $map = [
                'status'=>1
            ];
            $query->where($map);
        }])->field('id,real_name,mobile,first_leader,superior_id,superior_name,user_type')->order('task_count asc')->where($u_map)->select();
        return $user;
    }

    /*
     * 前台提交任务单
     */
    public function doSubTaskOrder($reqData,$uid){
        Db::startTrans();
        try{
            $error = ['code' => 0, 'msg' => 'error'];
            if(!isset($reqData['id']) || empty($reqData['id'])){
                $error['msg'] = '缺少参数';
                return $error;
            }
            $id = $reqData['id'];
            $info = db('Task')->where(['user_id'=>$uid,'id'=>$id])->find();
            if(!$info){
                $error['msg'] = '任务单不存在';
                return $error;
            }
            if($info['status']!=1){
                $error['msg'] = '任务单状态不是进行中';
                return $error;
            }
            if($reqData['fileNum']<=0){
                $error['msg'] = '任务单图片必须上传';
                return $error;
            }
            $taskImg = self::createTaskPic($reqData);
            if(!$taskImg){
                Db::rollback();
                $error['msg'] = '上传任务单图片失败';
                return $error;
            }
            //更新任务单状态
            $up_data = [
                'status'=>2,
                'update_time'=>time(),
            ];
            $taskStatus = self::where(['id'=>$id])->update($up_data);
            if(!$taskStatus){
                Db::rollback();
                $error['msg'] = '更新任务状态失败';
                return $error;
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];

        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }


    }
    /*
     * 处理任务提交图片
     */
    public function createTaskPic($reqData){
        $fileNum = $reqData['fileNum'];
        $taskId = $reqData['id'];
        if(intval($fileNum)>0){
            $picData = [];
            for($i=0;$i<$fileNum;$i++){
                $fileName = 'taskFile_'.$i;
                $file = request()->file($fileName);
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'task_order' );
                $imgPath = '/uploads/task_order/'.date('Ymd').'/';
                if($info){
                    $imgName = $imgPath.$info->getFilename();
                    $picData[$i]['task_id'] = $taskId;
                    $picData[$i]['pic'] = $imgName;
                    $picData[$i]['is_main'] = $i==0?1:0;
                }else{
                    // 上传失败获取错误信息
//                    echo $file->getError();
                }
            }
            if(count($picData)<=0){
                return false;
            }
            //删除原有图片
            db('TaskPic')->where(['task_id'=>$taskId])->delete();
            //插入图片
            $picRes = db('TaskPic')->insertAll($picData);
            if($picRes){
                return true;
            }
        }
        return false;
    }

    /*
     * 前台更新任务商品信息
     */
    public function doUpTaskInfo($reqData){
        $error = ['code'=>0,'msg'=>'error'];
        Db::startTrans();
        try{
            if(!isset($reqData['goods']['id'])){
                $error['msg'] = '商品信息格式错误';
                return $error;
            }
            $goods = $reqData['goods'];
            $update = [];
            $admin_id = session('admin_id');
            $taskRes = self::where(['superior_id'=>$admin_id,'id'=>$reqData['id']])->find();
            if(!$taskRes && $admin_id!=1){
                $error['msg'] = '商品信息格式错误';
                return $error;
            }
            if(!in_array($taskRes['status'],[1,2])){
                $error['msg'] = '任务状态不正确';
                return $error;
            }
            $orderRes = Order::where(['superior_id'=>$admin_id,'task_id'=>$reqData['id']])->column('id,task_id');
            $totalPrice = 0;//实际任务金额
            $gianPrice = 0;//实际任务佣金
            foreach($goods['id'] as $key=>$value){
                $id = $value;
                //判断是否非法操作商品
                if(!isset($orderRes[$id]) && $admin_id!=1){
                    $error['msg'] = '非法操作商品数据';
                    return $error;
                }
                $update[$key]['id'] = $value;
                $update[$key]['down_price'] = $goods['down_price'][$key];
                $update[$key]['gain_money'] = $goods['gain_money'][$key];
                $update[$key]['tb_user'] = $goods['tb_user'][$key];
                $update[$key]['remark'] = $goods['remark'][$key];
                $totalPrice += $goods['down_price'][$key];
                $gianPrice += $goods['gain_money'][$key];
            }
            $orderModel = new Order();
            $result = $orderModel->saveAll($update);
            if(!$result){
                Db::rollback();
                $error['msg'] = '更新商品数据失败';
                return $error;
            }
            $t_up = [
                'down_price'=>$totalPrice,
                'actual_money_total'=>$gianPrice,
            ];
            $taskRes = self::where(['id'=>$reqData['id']])->update($t_up);
            if(!$taskRes){
                Db::rollback();
                $error['msg'] = '更新任务金额与佣金失败';
                return $error;
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }
    /*
     * 后台审核任务
     */
    public function doTaskVerify($ids){
        $error = ['code'=>0,'msg'=>'error'];
        $admin_id = session('admin_id');
        Db::startTrans();
        try{
            $map = [
                'id'=>['IN',$ids],
                'status'=>['IN',[1,2]],
            ];
            if($admin_id!=1){
                //非超级管理员仅能审核自己名下任务单
                $map['superior_id'] = $admin_id;
            }
            $taskRes = self::with('order')->where($map)->select();
            if(empty($taskRes)){
                $error['msg'] = '无任务单可审核';
                return $error;
            }
            $taskIds = [];
            foreach($taskRes as $key=>$value){
                $unitTotal = $value['actual_money_total'];//实际获得佣金总额
                //操作负责人佣金
                $acc_data = [];
                $acc_data['operate'] = 2;//资金类型 1增加 2减少
                $acc_data['user_id'] = $value['superior_id'];//操作商家ID
                $acc_data['user_type'] = 3;//操作用户类型 1业务员 2商家 3管理员
                $acc_data['amount'] = $unitTotal;//操作金额
                $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
                $acc_data['task_id'] = $value['id'];//任务ID
                $acc_data['remark'] = '任务单审核，扣除佣金[任务编号:'.$value['id'].']';//操作备注
                $acc_res = Account::doUserAccount($acc_data);
                if($acc_res['code']!=200){
                    Db::rollback();
                    $error['msg'] = $acc_res['msg'];
                    return $error;
                }
                //操作业务员佣金
                $acc_data = [];
                $acc_data['operate'] = 1;//资金类型 1增加 2减少
                $acc_data['user_id'] = $value['user_id'];//操作业务员ID
                $acc_data['user_type'] = 1;//操作用户类型 1业务员 2商家 3管理员
                $acc_data['amount'] = $unitTotal;//操作金额
                $acc_data['type'] = 1;//操作类型 1佣金 2充值 3退款
                $acc_data['task_id'] = $value['id'];//任务ID
                $acc_data['remark'] = '任务完成，发放佣金[任务编号:'.$value['id'].']';//操作备注
                $acc_res = Account::doUserAccount($acc_data);
                if($acc_res['code']!=200){
                    Db::rollback();
                    $error['msg'] = $acc_res['msg'];
                    return $error;
                }
                $taskIds[] = $value['id'];
            }
            //更新任务状态
            $up_map['id'] = ['IN',$taskIds];
            $upTask = self::where($up_map)->setField('status',4);
            if(!$upTask){
                Db::rollback();
                $error['msg'] = '更新任务状态失败';
                return $error;
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }

    /*
     * 删除撤消任务单
     */
    public function doTaskCancel($ids,$regData){
        $error = ['code'=>0,'msg'=>'error'];
        $admin_id = session('admin_id');
        Db::startTrans();
        try{
            $map = [
                'id'=>['IN',$ids],
                'status'=>['IN',[1,2]],
            ];
            if($admin_id!=1){
                //非超级管理员仅能取消自己名下任务单
                $map['superior_id'] = $admin_id;
            }
            $taskRes = self::with('order')->where($map)->select();
            if(empty($taskRes)){
                $error['msg'] = '无任务单可取消';
                return $error;
            }
            $taskIds = [];
            foreach($taskRes as $key=>$value){
                //释放原任务订单
                $order = $value['order'];
                $orderIds = [];
                foreach($order as $info){
                    $orderIds[]=$info['id'];
                }
                //清空原订单信息
                $o_up = [];
                $o_up['task_id'] = '';
                $o_up['status'] = 0;
                $o_up['user_id'] = '';
                $o_up['user_name'] = '';
                $o_up['down_price'] = '';
                $o_up['tb_user'] = '';
                $o_up['tb_order_sn'] = '';
                $o_up['remark'] = '';
                $o_up['update_time'] = time();
                $orderRes = Order::where(['id'=>['IN',$orderIds]])->update($o_up);
                if(!$orderRes){
                    Db::rollback();
                    $error['msg'] = '更新订单信息失败';
                    return $error;
                }
                $taskIds[] = $value['id'];
            }
            //更新任务状态
            $up_map['id'] = ['IN',$taskIds];
            $up_t = [
                'status'=>5,
                'remarks'=>isset($regData['remarks'])?$regData['remarks']:'',

            ];
            $upTask = self::where($up_map)->update($up_t);
            if(!$upTask){
                Db::rollback();
                $error['msg'] = '更新任务状态失败';
                return $error;
            }
            Db::commit();
            return ['code'=>200,'msg'=>'成功'];
        }catch(\Exception $ex){
            Db::rollback();
            throw $ex;
        }
    }

}
