<?php
// 应用公共文件
use aliyun\SendSms;
use think\Cache;
/*
 * 压缩图片
 * $imgFile 图片地址
 */
function compressPic($imgFile){
    if(empty($imgFile)){
        return false;
    }
    if(strpos($imgFile,'public/uploads')==false){
        return false;
    }
    $image = \think\Image::open($imgFile);
    $width = $image->width();//返回图片宽度
    $height = $image->height();//返回图片高度
//    $type = $image->type();//返回图片类型
    if($width>800){
        //重新设置宽高
        $newWidth = 800;//新的图片宽度
        $widthBl = $newWidth/$width;
        $newHeight = intval($height*$widthBl);
        $image->thumb($newWidth,$newHeight)->save($imgFile);
    }
}
/*
 * 密码加密
 */
function encrypt($str)
{
    $auth_code = 'JianBan';
    return md5($auth_code . $str);
}
/*
 * 获取IP地址
 */
function getIpAddress(){
    $ip = request()->ip();
    return $ip;
}
/*
 * 分类树
 */
function getTree($arr,$space='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$pid=0,$level=0){
     if(!is_array($arr)){
         return false;
     }
     $newArr = [];
     foreach($arr as $value){
         if($value['pid'] ==$pid){
             $value['level'] = $level+1;
             $value['space'] = str_repeat($space,$level);
             $newArr[] = $value;
             $newArr = array_merge($newArr,getTree($arr,$space,$value['id'],$value['level']));
         }
     }
     return $newArr;
}
/*
 * 表单树数组转权限IDS
 */
function getFromGroupToIds($arr){
    if(!is_array($arr) || count($arr)<0){
        return false;
    }
    $ids = '';
    $chiIds = '';
    $threeIds = '';
    foreach($arr as $value){
        $ids .= $value['id'].',';
        if(isset($value['children']) && count($value['children'])>0){
            foreach($value['children'] as $vv){
                $chiIds .= $vv['id'].',';
                if(isset($vv['children']) && count($vv['children'])>0){
                    foreach($vv['children'] as $vvv){
                        $threeIds .= $vvv['id'].',';
                    }
                }
            }
        }
    }
    $chiIds = !empty($chiIds)?$chiIds:',';
    $newIds = $ids . $chiIds . rtrim($threeIds,',');
    $newIds = rtrim($newIds,',');
    return $newIds;
}

/*
 * 用户组分类树
 */
function getGroupTree($arr,$pid=0){
    if(!is_array($arr)){
        return false;
    }
    $groupArr = [];
    foreach($arr as $k=>$value){
        if($value['pid'] ==$pid){
            $v['id'] = $value['id'];
            $v['title'] = $value['name'];
            $v['spread'] = true;
            $v['children'] = getGroupTree($arr,$v['id']);
            $groupArr[]= $v;
        }
    }
    return $groupArr;
}
/*
 * 权限重组
 */
function getSysRule($ruleIds,$adminId=false){
    if(empty($ruleIds)){
        return false;
    }
    $map = [];
    $map['status'] = 1;
    if($adminId!=1){
        $map['id'] = ['IN',$ruleIds];
    }
    $sysRule = db('SystemRule')->where($map)->order('sort desc')->select();
    $menuArr = [];//菜单数组
    $ruleArr = [];//权限数组
    $groupArr = getGroupTree($sysRule);//用户组数组
    if(count($sysRule)>0){
        //获取顶级类目
        foreach($sysRule as $value){
            $ruleArr[] = strtolower($value['link']);
            if($value['pid']==0){
                $menuArr[]= $value;
            }
        }
        $ruleArr = array_unique($ruleArr);
        //获取二级类目
        foreach($menuArr as $key=>&$value){
            foreach($sysRule as $info){
                if($info['type']==1){
                    if($value['id'] == $info['pid']){
                        $menuArr[$key]['level'][] = $info;
                    }
                }
            }
        }
    }
    $data['menu_arr'] = $menuArr;
    $data['rule_arr'] = $ruleArr;
    $data['group_arr'] = $groupArr;
    return $data;
}

/*
 * 创建业务编码
 * @param $type
 * @return string
 */
function createTaskSn()
{
    $no = "";
    $i = rand(0, 999999);
    $no = 'sn' . date('YmdHis') . str_pad($i, 4, '0', STR_PAD_LEFT);
    return $no;
}
/*
     * $phone 手机号
     * $verify_code 验证码
     * $template 模板类型
     * 发送短信验证码
     */
function autoSendSms($mobile, $verify_code, $template)
{
    //获取短信接口配置
    $smsConfig = db('Config')->where(['inc_type' => 'api_info'])->column('name,value');
    $config = [
        'accessKeyId' => $smsConfig['msg_access_id'],
        'accessKeySecret' => $smsConfig['msg_access_secret'],
        'signName' => $smsConfig['msg_sign_name'],
    ];
    $tpl_code = '';
    switch ($template) {
        case '1'://注册
            $tpl_code = $smsConfig['msg_reg_code'];
            break;
        case '2'://找回密码
            $tpl_code = $smsConfig['msg_reg_code'];
            break;
        case '3'://修改密码
            $tpl_code = $smsConfig['msg_reg_code'];
            break;
        case '4'://修改手机号
            $tpl_code = $smsConfig['msg_reg_code'];
            break;
        case '5'://短信登录
            $tpl_code = $smsConfig['msg_reg_code'];
            break;
    }
    $aliSms = new SendSms($config);
    $result = $aliSms->send_verify($mobile, $verify_code, $tpl_code);
    if ($result['code'] != 0) {
        return ['code' => 1, 'msg' => $result['msg']];
    }
    return ['code' => 0, 'msg' => '发送成功,'];
}
/*
 * 多维数组转二维
 */
function multi2Array($array) {
    $resArr = [];
    foreach ($array as $key => $value) {
       foreach($value as $vv){
           $resArr[] = $vv;
       }
    }
    return $resArr;
}

/*
  * 随机重组
 * $order 原订单数组
 * $unite 几合一值
*/
function getUniteOrder($order,$unite){
//    dump($order);exit;
    if(count($order)<=0){
        return false;
    }
    //以城市归组订单
    $cityOrder = [];
    foreach($order as $key=>$value){
        $cityOrder[$value['city']][] = $value;
    }
//    dump($cityOrder);exit;
    $res = [];
    foreach($cityOrder as $key=>$order){
        $orders= orderToUnite($order,$unite);
        if(count($orders)>0){
            $res[$key][] = $orders;
        }

    }
//    exit;
//    dump($res);exit;
    //订单数组格式化二维
    $result = [];
    foreach($res as $key=>$value){
        $result[$key] = $value[0];
    }
    return $result;
    dump($result);exit;

}
/*
 * 任务订单小组生成
 * $order 订单
 * $unite 合一数
 */
function orderToUnite($order,$unite){
    $orderCount = count($order);//总订单数
    $avg = intval($orderCount/$unite);//平均值
    $newArr = [];
    for($i=0;$i<$avg;$i++){
        $info = getOrderGroup($order,$unite);//抽取订单数组
        if(is_array($info) && isset($info['data']) && count($info['data'])==$unite){
            $newArr[]=$info['data'];//取值数组
            $order = $info['repeat'];//剩余数组
        }else{
            continue;
        }

    }
    return $newArr;
}
/*
 * 任务订单小组生成
 * $order 订单
 * $unite 合一数
 */
function getOrderGroup($order,$unite){
    //去掉重复数据的数组
    $unique_arr = arrayUnique( $order,'shop_id');
    $un_conut = count($unique_arr);
    $oldUnite = $unite;
    $repeatNum = 0;
    if($un_conut<$unite){
        $unite = $un_conut;
        $repeatNum = $oldUnite-$unite;//缺省替补量
    }
    $uArr = getArrayRand($unique_arr,$unite);
//    dump($uArr);
    // 获取重复数据的数组
    $repeat_arr = arrayDiff( $order, $uArr );
//    dump($repeat_arr);exit;
    //判断合一数据是否充足
    if($repeatNum>0){
        //不足合一数，继续抽取替补
        $newUnArr = getArrayRand($repeat_arr,$repeatNum);
        $uArr = array_merge($uArr,$newUnArr);
//        dump($uArr);
        if(count($uArr)<$unite){
            return false;
        }
        // 获取重复数据的数组-剩余订单数组
        $repeat_arr = arrayDiff( $repeat_arr, $uArr );
//        dump($repeat_arr);exit;
    }
    $data['data'] = $uArr;//抽取的数组
    $data['repeat'] = $repeat_arr;
    return $data;
}
/*
 * 取二维随机数组
 */
function getArrayRand($unique_arr,$unite){
    $keyArr = array_rand($unique_arr,$unite);
    $uArr = [];
    if(is_array($keyArr) && count($keyArr)>0){
        foreach($keyArr as $value){
            $uArr[$value] = $unique_arr[$value];
        }
    }else{
        //随机数为1不必循环
        $uArr[$keyArr] = $unique_arr[$keyArr];
    }
    return $uArr;
}
/*
 * 多维数组键值对比，返回差集
 */
function arrayDiff($array1,$array2){
    $ret = array();
//    dump($array1);exit;
    //数组ID重组
    $arr = [];
    foreach($array1 as $value){
        $arr[$value['id']] = $value;
    }
//    dump($array1);exit;
    $arr2 = [];
    foreach($array2 as $value){
        $arr2[$value['id']] = $value;
    }
    foreach ($arr as $key => $value) {
       if(isset($arr2[$key])){
           unset($arr[$key]);
       }else{
           $ret[$key] = $value;
       }
    }
    return $ret;
}
/*
 * 多维数组去重
 * $arr 原始数组
 * $key 键值
 */
function arrayUnique($arr,$key){
    $res = array();
    foreach ($arr as $value) {
        if(isset($res[$value[$key]])){
            unset($value[$key]);
        }
        else{
            $res[$value[$key]] = $value;
        }
    }
    $newArr = [];
    foreach($res as $value){
        $newArr[$value['id']] = $value;
    }
    return $newArr;
}

function fun($arr=array(), $number = '')
{
    $a  = array_rand($arr, $number);
    $data = array();
    foreach ($a as $v) {
        $data[] = $arr[$v];
    }
    $arr_new = array_diff($arr, $data);
    return array(
        'arr_new' => $arr_new,
        'data'      => $data
    );
}

/*
 * 函数说明：验证身份证是否真实
 * 注：加权因子和校验码串为互联网统计  尾数自己测试11次 任意身份证都可以通过
 * 传递参数：
 * $card 身份证号码
 * 返回参数：
 * true验证通过
 * false验证失败
 */
function isIdCard($card) {
    $sigma = '';
    //加权因子
    $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码串
    $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    //按顺序循环处理前17位
    for ($i = 0;$i < 17;$i++) {
        //提取前17位的其中一位，并将变量类型转为实数
        $b = (int) $card{$i};
        //提取相应的加权因子
        $w = $wi[$i];
        //把从身份证号码中提取的一位数字和加权因子相乘，并累加 得到身份证前17位的乘机的和
        $sigma += $b * $w;
    }
    //计算序号  用得到的乘机模11 取余数
    $snumber = $sigma % 11;
    //按照序号从校验码串中提取相应的余数来验证最后一位。
    $check_number = $ai[$snumber];
    if ($card{17} == $check_number) {
        return true;
    } else {
        return false;
    }
}
/*
 * 格式化金额保留2位小数
 */
function sprintNum($money){
    if(!is_numeric($money)){
        return false;
    }
    return sprintf('%.2f',$money);
}
/**
 * 数字金额转换成中文大写金额,要求小数位数为两位
 * @param $num 要转换的小写数字或小写字符串
 * @return 大写金额字符串
 */
function moneyFormat($num)
{
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    $num = round($num, 2);
    $num = $num * 100;
    if (strlen($num) > 11) {
        return "";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            $n = substr($num, strlen($num) - 1, 1);
        } else {
            $n = $num % 10;
        }
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        $num = $num / 10;
        $num = (int)$num;
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        $m = substr($c, $j, 6);
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j - 3;
            $slen = $slen - 3;
        }
        $j = $j + 3;
    }
    if (substr($c, strlen($c) - 3, 3) == '零') {
        $c = substr($c, 0, strlen($c) - 3);
    }
    if (empty($c)) {
        return "零元整";
    } else {
        return $c . "整";
    }
}
/*
 * 通用数据导出
 */
function dataExportToXsl(){

}
/*
 *
 */
function request_post($url = '', $post_data = array()) {
    if (empty($url) || empty($post_data)) {
        return false;
    }
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}
/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

/*
 * 通用菜单类
 */
function linkage($type=''){
    $linkage = [
        'system'=>[
            'template'=>['1'=>'/static/images/template_01.png','2'=>'/static/images/template_02.png'],
        ],
        'rule'=>[
            'type'=>['1'=>'菜单','2'=>'按钮'],
            'status'=>['0'=>'禁用','1'=>'启用'],
            'spread'=>['0'=>'否','1'=>'是'],
        ],
        'member'=>[
            'status'=>['0'=>'禁用','1'=>'启用','2'=>'不通过'],
            'card_status'=>['0'=>'待提交','1'=>'待审核','2'=>'审核通过','3'=>'审核不通过'],
            'bank_status'=>['0'=>'待提交','1'=>'待审核','2'=>'审核通过','3'=>'审核不通过'],
            'is_real'=>['0'=>'待认证','1'=>'已认证'],
            'invite_auth'=>['0'=>'关闭','1'=>'开启'],
            'user_type'=>['1'=>'业务员','2'=>'团长'],
            'is_back'=>['0'=>'否','1'=>'是'],
            'sex'=>['0'=>'保密','1'=>'男','2'=>'女'],
        ],
        'shop'=>[
            'status'=>['0'=>'待审核','1'=>'审核通过','2'=>'审核未通过'],
            'shop_type'=>['1'=>'淘宝','2'=>'京东','3'=>'拼多多'],
        ],
        'tpl'=>[
            'status'=>['0'=>'待审核','1'=>'审核通过','2'=>'审核未通过'],
            'sort_type'=>['1'=>'按综合排序','2'=>'按人气排序','3'=>'按销量排序'],
            'view_time'=>['0'=>'不限','1'=>'1-5分','2'=>'6-10分','3'=>'11-15分','4'=>'16-20分','5'=>'21-25分'],
        ],
        'plan'=>[
            'status'=>['0'=>'待审核','1'=>'已审核','2'=>'进行中','3'=>'已完成','4'=>'审核不通过','5'=>'已撤消'],
        ],
        'task'=>[
            'status'=>['1'=>'正在进行','2'=>'已提交待审','3'=>'审核不通过','4'=>'已完成','5'=>'已撤消'],
            'sort_type'=>['1'=>'按综合排序','2'=>'按人气排序','3'=>'按销量排序'],
            'view_time'=>['0'=>'不限','1'=>'1-5分','2'=>'6-10分','3'=>'11-15分','4'=>'16-20分','5'=>'21-25分'],
            'repeat'=>['0'=>'不允许重合','1'=>'1个','2'=>'2个','3'=>'3个','10'=>'10个'],
            'unite'=>['1'=>'1合一','2'=>'2合一','3'=>'3合一','4'=>'4合一','5'=>'5合一','6'=>'6合一','7'=>'7合一','8'=>'8合一','9'=>'9合一','10'=>'10合一'],
        ],
        'order'=>[
            'status'=>['0'=>'待拍下','1'=>'进行中','2'=>'已完成'],
        ],
        'recharge'=>[
            'status'=>['0'=>'待审核','1'=>'审核通过','2'=>'驳回'],
        ],
        'withdraw'=>[
            'status'=>['0'=>'申请中','1'=>'申请成功','2'=>'申请失败'],
            'type'=>['1'=>'微信','2'=>'支付宝','3'=>'转账'],
        ],
        'message'=>[
            'platform'=>['0'=>'所有端','1'=>'联盟端','2'=>'商家端','3'=>'业务员端'],
            'type'=>['1'=>'弹窗','2'=>'链接'],
            'status'=>['0'=>'待发布','1'=>'已发布','2'=>'已结束'],
        ],
        'work_order'=>[
            'type'=>['1'=>'提问','2'=>'反馈','3'=>'讨论','4'=>'分享'],
            'status'=>['0'=>'未分配','1'=>'处理中','2'=>'已处理'],
        ],
    ];
    if(!empty($type)){
        if(isset($linkage[$type])){
            return $linkage[$type];
        }
    }
    return $linkage;
}
function generateToken()
{
    $randChar = getRandChar(32);
    //三组字符，进行MD5加密
    $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
    $tokenSalt = 'dit';
    return md5($randChar . $timestamp . $tokenSalt);
}
/*
 * 设置Token
 */
function setTokenVar($values){
    $token = generateToken();
    $expire_in = 3600 * 3;
    cache($token, json_encode($values), $expire_in);
    return $token;
}
/*
 * 删除Token
 */
function delTokenVar($token){
    $result= cache($token,NULL);
    if($result){
        return true;
    }else{
        return false;
    }
}
/*
 * 获取Token
 */
function getTokenVar($key)
{
//    $token = Request::instance()->header('Auth-Token');
    $token = request()->header('Auth-Token');
    if(empty($token)){
        return false;
    }
    $vars = cache($token);
    if (!$vars) {
        return false;
    } else {
        if (!is_array($vars)) {
            $vars = json_decode($vars, true);
        }
        if (array_key_exists($key, $vars)) {
            return $vars[$key];
        } else {
          return false;
        }
    }
}
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}
function reSuccess($msg,$data=[]){
    $res = ['code'=>0,'msg'=>$msg,'data'=>$data];
    echo json_encode($res,JSON_UNESCAPED_UNICODE);
    exit;
}
function reError($msg,$data=[],$code=100){
    $res = ['code'=>$code,'msg'=>$msg,'data'=>$data];
    echo json_encode($res,JSON_UNESCAPED_UNICODE);
    exit;
}
//图片地址统一处理
function getImgUrl($pic){
    $imgUrl='';
    if($pic){
        $imgUrl= 'http://dt.xxylfh.cn'.$pic;
    }
    return $imgUrl;
}
