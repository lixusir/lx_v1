<?php
namespace app\admin\controller;
use app\admin\model\Users as userModel;
use app\admin\model\UserAccount as userAccountModel;
class Member extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 团长列表
     */
    public function tuanList()
    {
        $linkage = linkage('member');
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 业务员列表
     */
    public function userList()
    {
        $linkage = linkage('member');
        $type = input('get.type',1);
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            if($type==2){
                $where['status'] = 1;//已审核
            }elseif($type==3){
                $where['status'] = '0';//待审核
            }elseif($type==4){
                $where['status'] = 2;//审核不通过
            }
            if($type==5){
                //显示团长
                $where['user_type'] = 2;
            }
            $mobile = input('post.mobile');
            if (!empty($mobile)) {
                $where['mobile'] = $mobile;
            }
            $real_name = input('post.real_name');
            if (!empty($real_name)) {
                $where['real_name'] = ['like', "%" . $real_name . "%"];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $first_leader = input('post.first_leader');
            if (isset($first_leader) && $first_leader != '') {
                $where['first_leader'] = $first_leader;
            }
            $tb_user = input('post.tb_user');
            if (isset($tb_user) && $tb_user != '') {
                $where['tb_user'] = $tb_user;
            }
            $is_back = input('post.is_back');
            if (isset($is_back) && $is_back != '') {
                $where['is_back'] = $is_back;
            }
            $is_real = input('post.is_real');
            if (isset($is_real) && $is_real != '') {
                $where['is_real'] = $is_real;
            }
            $user_id = input('post.user_id');
            if (isset($user_id) && $user_id != '') {
                $where['id'] = $user_id;
            }
            //显示联盟用户下管理员
            $superior_id = session('admin_id');
            if($superior_id!=1){
                $where['superior_id'] = $superior_id;
            }
            $list = userModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('type',$type);
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 团长/业务员编辑
     */
    public function userEdit(){
        $linkage = linkage('member');
        $admin_id = session('admin_id');
        $type = input('param.type',1);
        $userModel = new userModel();
        if(request()->isPost()){
             $regData = input('param.');
             $result = $userModel->doEditUser($regData);
             if($result['code']!=200){
                 $this->error($result['msg']);
             }
             $goUrl = url('Member/userList');
             if($type==2){
                 $goUrl = url('Member/tuanList');
             }
            $this->success('操作成功',$goUrl);
        }else{
            $id = input('get.id/d');
            $info = $userModel->where(['id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
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
            $this->assign('type',$type);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 业务员或团长删除
     */
    public function userDel(){
        $admin_id = session('admin_id');
        $id = input('param.id');
        $info = userModel::where(['id'=>$id])->find();
        if(!$info){
            $this->error('未找到用户');
        }
        if($info['superior_id'] !=$admin_id && $admin_id!=1){
            $this->error('非法操作');
        }
        if($info['type']==2){
            //判断是否有业务员归属此团长
            $leader = userModel::where(['first_leader'=>$id])->count();
            if($leader){
                $this->error('抱歉，此团长有下属业务员，暂时无法删除');
            }
        }
        $result = userModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
    /*
     * 用户资金明细列表
     */
    public function accountList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $time = input('post.time');
            if(isset($time) && !empty($time)){
                $time_arr = explode(' - ',$time);
                $where['create_time'] = ['between time',[$time_arr[0].' 00:00:01',$time_arr[1].' 23:59:59']];
            }
            $mobile = input('post.mobile');
            if (!empty($mobile)) {
                $where['mobile'] = $mobile;
            }
            $user_id = input('post.user_id');
            if (isset($user_id) && $user_id != '') {
                $where['id'] = $user_id;
            }
            //显示联盟用户下管理员
            $superior_id = session('admin_id');
            if($superior_id!=1){
                $where['superior_id'] = $superior_id;
            }
            $list = userAccountModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
}