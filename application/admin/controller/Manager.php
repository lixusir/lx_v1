<?php
namespace app\admin\controller;
use app\admin\model\Admin as adminModel;
use app\admin\model\AdminGroup as adminGroupModel;
class Manager extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 管理员列表
     */
    public function adminList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $phone = input('post.phone');
            if (!empty($phone)) {
                $where['phone'] = $phone;
            }
            $userName = input('post.user_name');
            if (!empty($userName)) {
                $where['user_name'] = ['like', "%" . $userName . "%"];
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            //显示联盟用户下管理员
            $superior_id = session('admin_id');
            if($superior_id!=1){
                $where['superior_id'] = $superior_id;
            }
            $list = adminModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            $linkage = linkage('member')['status'];
            $group = db('AdminGroup')->column('id,name');
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage[$value['status']];
                $value['group_text'] = $group[$value['group_id']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
    /*
     * 管理员编辑
     */
    public function adminEdit(){
        $linkage = linkage('member');
        $admin_id = session('admin_id');
        if(request()->isPost()){
             $reqData = input('param.');
             $adminModel = new adminModel();
             $result = $adminModel->doAdminEdit($reqData,$admin_id);
             if(isset($result['code']) && $result['code']==200){
                 $this->success('操作成功',url('Manager/adminList'));
             }
             $this->error($result['msg']);
        }else{
            $id = input('get.id/d');
            $info = db('Admin')->where(['id'=>$id])->find();
            if($info){
                if($info['superior_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
            }
            //管理组列表
            $auth_group = db('AdminGroup')->where(['admin_id'=>$admin_id])->order('id desc')->select();
            $this->assign('info',$info);
            $this->assign('auth_group',$auth_group);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 管理员删除
     */
    public function adminDel(){
        $admin_id = session('admin_id');
        $id = input('param.id');
        $info = db('Admin')->where(['id'=>$id])->find();
        if($info){
            if($info['superior_id'] !=$admin_id && $admin_id!=1){
                $this->error('非法操作');
            }
        }
        $result = adminModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
    /*
     * 管理组列表
     */
    public function groupList()
    {
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            //显示用户名下的用户组
            $admin_id = session('admin_id');
            if($admin_id!=1){
                $where['admin_id'] = $admin_id;
            }
            $sea_admin_id = input('post.admin_id');
            if (!empty($sea_admin_id) &&  $admin_id==1) {
                $where['admin_id'] = $sea_admin_id;
            }
            $list = adminGroupModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            $linkage = linkage('member')['status'];
            $admins = db('Admin')->column('id,user_name');
            foreach($list['data'] as &$value){
                $value['status_text'] = $linkage[$value['status']];
                $value['admin_name'] = $admins[$value['admin_id']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        return view();
    }
    /*
     * 管理组编辑
     */
    public function groupEdit(){
        $linkage = linkage('member');
        $admin_id = session('admin_id');
        if(request()->isPost()){
            $regData = input('param.');
            $groupData = $regData['group_data'];
//            dump($groupData);exit;
            $group_ids = getFromGroupToIds($groupData);
            $data = [
                'name'=>$regData['name'],
                'admin_id'=>$admin_id,
                'rules'=>$group_ids,
                'status'=>$regData['status'],
            ];
            if(empty($group_ids)){
                $this->error('请勾选权限');
            }
            $aId = $regData['id'];
            if(isset($aId) && !empty($aId)){
                $data['id'] = $aId;
                //查找用户
                $admins = adminGroupModel::where(['admin_id'=>$admin_id,'id'=>$aId])->find();
                if(!$admins && $admin_id!=1 ){
                    $this->error('非法操作');
                }
                $result = adminGroupModel::update($data);
            }else{
                $data['create_time'] = time();
                $result = adminGroupModel::create($data);
            }
            if($result){
                $this->success('操作成功',url('Manager/groupList'));
            }
            $this->error('操作失败');
        }else{
            $id = input('get.id/d');
            $info = db('AdminGroup')->where(['id'=>$id])->find();
            $checkGid = '[]';
            if($info){
                if($info['admin_id'] !=$admin_id && $admin_id!=1){
                    $this->error('非法操作');
                }
                $checkGid = '['.$info['rules'].']';
            }
            //管理组列表
            $group_arr = session('group_arr');
            $this->assign('info',$info);
            $this->assign('group_arr',json_encode($group_arr,JSON_UNESCAPED_UNICODE));
            $this->assign('check_gid',$checkGid);
            $this->assign('linkage',$linkage);
            return $this->fetch();
        }
    }
    /*
     * 管理组删除
     */
    public function groupDel(){
        $admin_id = session('admin_id');
        $id = input('param.id');
        $info = db('AdminGroup')->where(['id'=>$id])->find();
        if(!$info){
            $this->error('无此用户组');
        }
        if($info['admin_id'] !=$admin_id && $admin_id!=1){
            $this->error('非法操作');
        }
        //判断是否有管理归属此用户组
        $adminGroup = adminModel::where(['group_id'=>$id])->count();
        if($adminGroup){
            $this->error('抱歉，此用户组被占用，请编辑使用此用户组的管理员');
        }
        $result = adminGroupModel::where(['id'=>$id])->delete();
        if($result){
            $this->success('操作成功');
        }
        $this->error('操作失败');

    }
}