<?php
namespace app\api\controller;
use app\model\Users as userModel;
use app\model\AccountLog as accLogModel;
use app\model\Withdraw as withModel;
use app\model\WorkOrder as workModel;
use app\model\Message as msgModel;
class User extends ApiBase{
    /*
     * 登录
     */
    public function login(){
        echo 1;die;
        $regData = input('param.');
//        dump($regData);exit;
        $userModel = new userModel();
        $result = $userModel->doLogin($regData);
        if(isset($result['code']) && $result['code']==200){
            reSuccess('登录成功',$result['data']);
        }
        reError($result['msg']);
    }
    /*
     * 退出登录
     */
    public function logout(){
        $token = request()->header('Auth-Token');
        if (!$token) {
            reError('token不允许为空');
        }
        $uid = getTokenVar('uid');
        if(empty($uid)){
            delTokenVar($token);
            reSuccess('退出成功');
        }
        //查找用户信息
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        //记录退出日志
        $log_data = [
            'type'=>'3',
            'user_id'=>$uid,
            'user_name'=>$userInfo['real_name'],
            'out_time'=>time(),
            'out_ip'=>getIpAddress(),
        ];
        db('LoginLog')->insert($log_data);
        delTokenVar($token);
        reSuccess('退出成功');
    }
    /*
     * 更改密码
     */
    public function upPassword(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录');
        }
        //获取用户信息
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $reqData = input('param.');
        if(!isset($reqData['old_password']) || empty($reqData['old_password'])){
            reError('请输入原密码');
        }
        $pwd = encrypt($reqData['old_password']);
        if($userInfo['password']!=$pwd){
            reError('原密码错误，请重新输入');
        }
        if(!isset($reqData['password']) || empty($reqData['password'])){
            reError('请输入新密码');
        }
        if(!isset($reqData['re_password']) || empty($reqData['re_password'])){
            reError('请输入确认密码');
        }
        if($reqData['password']!=$reqData['re_password']){
            reError('两次密码输入不相同');
        }
        $newPwd = encrypt($reqData['password']);
        $update = [
            'password'=>$newPwd,
            'password_str'=>$reqData['password'],
            'update_time'=>time(),
        ];
        $res = db('Users')->where(['id'=>$uid])->update($update);
        if(!$res){
            reError('修改密码失败了，请重试');
        }
        reSuccess('修改成功');
    }
    /*
     * 获取用户信息
     */
    public function getUserInfo(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        //获取用户信息
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $data = [
            'user_type' =>$userInfo['user_type'],
            'account' =>$userInfo['mobile'],
            'name' => $userInfo['real_name'],
            'balance' => $userInfo['user_money'],
            'taobaoUser' => $userInfo['tb_user'],
            'bank' => $userInfo['bank_name'],
            'bank_number' => $userInfo['bank_number'],
            'bank_remark' => $userInfo['bank_remark'],
            'bank_status' => $userInfo['bank_status'],
            'front' => !empty($userInfo['front'])?getImgUrl($userInfo['front']):'',
            'reverse' => !empty($userInfo['reverse'])?getImgUrl($userInfo['reverse']):'',
            'pose' => !empty($userInfo['pose'])?getImgUrl($userInfo['pose']):'',
            'card_no' => $userInfo['card_no'],
            'card_remark' => $userInfo['card_remark'],
            'card_status' => $userInfo['card_status'],
            'sex' => $userInfo['sex'],
            'qq' => $userInfo['qq'],
            'wechat' => $userInfo['wechat'],
            'ship_addr' => $userInfo['ship_addr'],
            'address' => $userInfo['address'],
            'is_real' => $userInfo['is_real'],
            'is_bank' => $userInfo['is_bank'],
            'status' => $userInfo['status'],
            'userType' => $userInfo['user_type'],
        ];
        //历史总收益
        $map = [
            'user_id'=>$uid,
            'user_type'=>1,//类型 1业务员 2商家 3管理员
            'operate'=>1,//类型 1增加 2减少

        ];
        $historyMoney = db('AccountLog')->where($map)->sum('exc_money');
        $data['history_money'] = sprintNum($historyMoney);
        reSuccess('成功',$data);
    }
    /*
     * 用户收益记录
     */
    public function earningsList(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $page = input('param.page');
        $perPage = input('param.per_page', 10);
        $where = [
            'user_id'=>$uid,
            'user_type'=>1,//类型 1业务员 2商家 3管理员
        ];
        $result = accLogModel::where($where)->order('id desc')->paginate($perPage, false, ['page' => $page])->toArray();
        $data = [
            'pageCount' => $perPage,
            'currPage' => $result['current_page'],
            'perPage' => $result['per_page'],
            'totalCount' => $result['total'],
            'list' => $result['data']
        ];
        if(count($result['data'])<=0){
            $data = null;
        }
        reSuccess('成功', $data);
    }
    /*
     * 提现申请
     */
    public function subWithdraw(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $reqData = input('post.');
        $userModel = new userModel();
        $result = $userModel->doWithdraw($reqData, $userInfo);
        if(isset($result['code']) && $result['code']==200){
            reSuccess('提现成功');
        }
        reError($result['msg']);
    }
    /*
     * 用户提现记录
     */
    public function withdrawList(){
        $linkage = linkage('withdraw');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $page = input('param.page');
        $perPage = input('param.per_page', 10);
        $where = [
            'user_id'=>$uid,
            'user_type'=>1,//类型 1业务员 2商家 3管理员
        ];
        $result = withModel::where($where)->order('id desc')->paginate($perPage, false, ['page' => $page])->toArray();
        if(count($result['data'])>0){
            foreach($result['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
            }
        }
        $data = [
            'pageCount' => $perPage,
            'currPage' => $result['current_page'],
            'perPage' => $result['per_page'],
            'totalCount' => $result['total'],
            'list' => $result['data']
        ];
        if(count($result['data'])<=0){
            $data = null;
        }
        reSuccess('成功', $data);
    }

    /*
     * 用户实名认证
     */
    public function doCard(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $reqData = input('post.');
        $userModel = new userModel();
        $result = $userModel->userDoCard($reqData, $userInfo);
        if(isset($result['code']) && $result['code']==200){
            reSuccess('提交成功');
        }
        reError($result['msg']);
    }

    /*
     * 用户银行卡认证
     */
    public function bindBank(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $reqData = input('post.');
        $userModel = new userModel();
        $result = $userModel->userDoBank($reqData, $userInfo);
        if(isset($result['code']) && $result['code']==200){
            reSuccess('成功');
        }
        reError($result['msg']);
    }

    /*
     * 用户工单列表
     */
    public function workList(){
        $linkage = linkage('work_order');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $page = input('param.page');
        $perPage = input('param.per_page', 10);
        $where = [
            'user_id'=>$uid,
            'user_type'=>1,//类型 1业务员 2商家 3管理员
        ];
        $result = workModel::where($where)->order('id desc')->paginate($perPage, false, ['page' => $page])->toArray();
        if(count($result['data'])>0){
            foreach($result['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
                $value['type_text'] = $linkage['type'][$value['type']];
            }
        }
        $data = [
            'pageCount' => $perPage,
            'currPage' => $result['current_page'],
            'perPage' => $result['per_page'],
            'totalCount' => $result['total'],
            'list' => $result['data']
        ];
        if(count($result['data'])<=0){
            $data = null;
        }
        reSuccess('成功', $data);
    }
    /*
     * 工单详情
     */
    public function workView(){
        $linkage = linkage('work_order');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $id = input('param.id');
        $map = [
            'user_id'=>$uid,
            'user_type'=>1,
            'id'=>$id,
        ];
        $workRes = db('WorkOrder')->where($map)->find();
        if(!$workRes){
            reError('工单不存在');
        }
        $workRes['content'] = strip_tags($workRes['content'],'<br>');
        $workRes['create_time'] = !empty($workRes['create_time'])?date('Y-m-d H:i:s',$workRes['create_time']):'';
        $workRes['accept_time'] = !empty($workRes['accept_time'])?date('Y-m-d H:i:s',$workRes['accept_time']):'';
        $workRes['type'] = $linkage['type'][$workRes['type']];
        reSuccess('成功',$workRes);
    }
    /*
     * 用户银行卡认证
     */
    public function workEdit(){
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('未登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $reqData = input('param.');
        if(!isset($reqData['type_id']) || empty($reqData['type_id'])){
            reError('工单类型必须选择');
        }
        if(!isset($reqData['title']) || empty($reqData['title'])){
            reError('工单标题不能为空');
        }
        if(!isset($reqData['content']) || empty($reqData['content'])){
            reError('工单内容不能为空');
        }
        $data = [
            'superior_id' => $userInfo['superior_id'],
            'user_type' => 1,
            'user_id' => $uid,
            'user_name' => !empty($userInfo['real_name'])?$userInfo['real_name']:$userInfo['mobile'],
            'title' => $reqData['title'],
            'type' => $reqData['type_id'],
            'speed' => 0,
            'content' => $reqData['content'],
            'create_time' => time(),
            'status' => 0,
        ];
        $result = db('WorkOrder')->insert($data);
        if($result){
            reSuccess('提交成功');
        }
        reError('提交失败');
    }

    /*
     * 用户公告列表
     */
    public function noticeList(){
        $linkage = linkage('message');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $page = input('param.page');
        $perPage = input('param.per_page', 10);
        $time = time();
        $where = [
            'platform'=>['IN',[0,3]],
            'begin_time'=> ['ELT',$time],
            'end_time'=> ['EGT',$time],
        ];
        $result = msgModel::where($where)->order('id desc')->paginate($perPage, false, ['page' => $page])->toArray();
        if(count($result['data'])>0){
            foreach($result['data'] as &$value){
                $value['status_text'] = $linkage['status'][$value['status']];
            }
        }
        $data = [
            'pageCount' => $perPage,
            'currPage' => $result['current_page'],
            'perPage' => $result['per_page'],
            'totalCount' => $result['total'],
            'list' => $result['data']
        ];
        if(count($result['data'])<=0){
            $data = null;
        }
        reSuccess('成功', $data);
    }
    /*
     * 公告详情
     */
    public function noticeView(){
        $linkage = linkage('message');
        $uid = getTokenVar('uid');
        if(empty($uid)){
            reError('请登录',[],10);
        }
        $userInfo = db('Users')->where(['id'=>$uid])->find();
        if(!$userInfo){
            reError('用户不存在');
        }
        $id = input('param.id');
        $time = time();
        $map = [
            'platform'=>['IN',[0,3]],
            'begin_time'=> ['ELT',$time],
            'end_time'=> ['EGT',$time],
            'id'=>$id
        ];
        $noticeRes = db('Message')->where($map)->find();
        if(!$noticeRes){
            reError('公告不存在');
        }
        $noticeRes['content'] = strip_tags($noticeRes['content'],'<br>');
        $noticeRes['create_time'] = !empty($noticeRes['create_time'])?date('Y-m-d H:i:s',$noticeRes['create_time']):'';
        reSuccess('成功',$noticeRes);
    }
}
