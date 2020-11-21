<?php
namespace app\admin\controller;
use app\model\Recharge as rechargeModel;
use app\model\AccountLog;
class Money extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 充值列表
     */
    public function rechargeList()
    {
        $linkage = linkage('recharge');
        $admin_id = session('admin_id');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['seller_id'] = $admin_id;
            $where['user_type'] = 3;//用户类型 1业务员 2商家 3管理员
            $time = input('post.time');
            if(isset($time) && !empty($time)){
                $time_arr = explode(' - ',$time);
                $where['create_time'] = ['between time',[$time_arr[0].' 00:00:01',$time_arr[1].' 23:59:59']];
            }
            $status = input('post.status');
            if (!empty($status)) {
                $where['status'] = $status;
            }
            $list = rechargeModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach ($list['data'] as &$val){
                $val['status_des']=$linkage['status'][$val['status']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 新增充值
     */
    public function rechargeEdit(){
        $linkage = linkage('recharge');
        $seller_id = session('admin_id');
        $seller_name = session('admin_name');
        $seller_mobile = session('admin_mobile');
        $superior_id = session('superior_id');
        $admins = db('Admin')->where(['id'=>$superior_id])->find();
        if(request()->isPost()){
            $reqData = input('post.');
            if(empty($reqData['cert_pic'])){
                $this->error('请上传转账凭证');
            }
            $data=[
                'user_type'=>3,
                'seller_id'=>$seller_id,
                'seller_name'=>$seller_name,
                'seller_mobile'=>$seller_mobile,
                'superior_id'=>$superior_id,
                'money'=>$reqData['money'],
                'cn_money'=>!empty($reqData['money']) ? moneyFormat($reqData['money']) : '',
                'real_name'=>$reqData['real_name'],
                'bank_id'=>$reqData['bank_id'],
                'bank_account_name'=>$admins['real_name'],
                'bank_name'=>$admins['bank_name'],
                'bank_number'=>$admins['bank_number'],
                'cert_pic'=>$reqData['cert_pic'],
                'create_time'=>time(),
                'status'=>0,
            ];
            $result = rechargeModel::create($data);
            if($result){
                $this->success('操作成功',url('Money/rechargeList'));
            }
            $this->error('操作失败');
        }else{
            $this->assign('info',$admins);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 资金流水
     */
    public function moneyList()
    {
        $linkage = linkage('recharge');
        $admin_id = session('admin_id');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['user_type'] = 3;
            $where['user_id'] = $admin_id;
            $time = input('post.time');
            if(isset($time) && !empty($time)){
                $time_arr = explode(' - ',$time);
                $where['create_time'] = ['between time',[$time_arr[0].' 00:00:01',$time_arr[1].' 23:59:59']];
            }
            $plan_id = input('post.plan_id');
            if(isset($plan_id) && !empty($plan_id)){
                $where['plan_id'] = $plan_id;
            }
            $status = input('post.status');
            if (!empty($status)) {
                $where['status'] = $status;
            }
            $list = AccountLog::where($where)->order('id desc')->paginate($pageSize)->toArray();
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('linkage',$linkage);
        return view();
    }

    /*
     * 应收店铺账目
     */
    public function shopAccount(){

    }

    /*
     * 应收业务员账目
     */
    public function userAccount(){

    }
}