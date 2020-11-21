<?php
namespace app\seller\controller;
use app\model\Order AS orderModel;
use think\Loader;

class Order extends SellerBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }
    /*
     * 订单列表
     */
    public function orderList()
    {
        $type = input('get.type',1);
        $linkage = linkage('order');
        if (request()->isPost()) {
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $where = [];
            $where['seller_id'] = session('seller_id');
            $where['status'] = 1;
            if($type==2){
                $where['status'] = 1;
            }elseif($type==3){
                $where['status'] = 2;
            }
            $goods_id = input('post.goods_id');
            if (isset($goods_id) && $goods_id != '') {
                $where['goods_id'] = $goods_id;
            }
            $tb_user = input('post.tb_user');
            if (isset($tb_user) && $tb_user != '') {
                $where['tb_user'] = $tb_user;
            }
            $tb_order_sn = input('post.tb_order_sn');
            if (isset($tb_order_sn) && $tb_order_sn != '') {
                $where['tb_order_sn'] = $tb_order_sn;
            }
            $shop_name = input('post.shop_name');
            if (isset($shop_name) && $shop_name != '') {
                $where['shop_name'] = $shop_name;
            }
            $status = input('post.status');
            if (isset($status) && $status != '') {
                $where['status'] = $status;
            }
            $list = orderModel::where($where)->order('id desc')->paginate($pageSize)->toArray();
            foreach($list['data'] as $key=>&$value){
                $value['status_text'] = $linkage['status'][$value['status']];
            }
            return $result = ['code' => 0, 'msg' => '获取成功!', 'data' => $list['data'], 'count' => $list['total']];
        }
        $this->assign('type',$type);
        $this->assign('linkage',$linkage);
        return view();
    }
    /*
     * 查看订单
     */
    public function orderView(){
        $linkage = linkage('tpl');
        $seller_id = session('seller_id');
        $obs_url = linkage('obs_config')['urls'];
        $id = input('get.id/d');
        $info = orderModel::where(['id'=>$id])->find();
        if($info){
            if($info['seller_id'] !=$seller_id){
                $this->error('非法操作');
            }
        }
        $this->assign('info',$info);
        $this->assign('linkage',$linkage);
        $this->assign('obs_url',$obs_url);
        return $this->fetch();

    }
    /*
     * 打款管理
     */
    public function payList(){

    }
    /*
     * 订单导出
     */
    public function exportOrder() {
        $where = [];
        $where['seller_id'] = session('seller_id');
        $where['status'] = array('neq', 4);
        $ids = input('post.ids/a');
        if (!empty($ids)) {
            $where['id'] = ['IN', $ids];
        }
        $whereArr = input('post.where/a');
//        dump($whereArr);exit;
        if (isset($whereArr['tb_user']) && $whereArr['tb_user'] != '') {
            $where['tb_user'] = $whereArr['tb_user'];
        }
        $tb_order_sn = $whereArr['tb_order_sn'];
        if (isset($tb_order_sn) && $tb_order_sn != '') {
            $where['tb_order_sn'] = $tb_order_sn;
        }
        $shop_name = $whereArr['shop_name'];
        if (isset($shop_name) && $shop_name != '') {
            $where['shop_name'] = $shop_name;
        }
        if (isset($whereArr['status']) && $whereArr['status'] != '') {
            $where['status'] = $whereArr['status'];
        }
        $result = orderModel::where($where)->select();
        if(count($result)<=0){
            $this->error('暂无数据可导出');
        }
        $exData = [];
        $linkage = linkage('order');
        $down_price_count = 0;
        foreach($result as $value){
            $exData[] = [
                $value['shop_name'],
                $value['tb_user'],
                $value['tb_order_sn'],
                $value['money'],
                $value['down_price'],
                $value['create_time'],
                $val['status_des'] = $linkage['status'][$value['status']],
            ];
            $down_price_count += $value['down_price'];
        }
        $total[] = ['','','','',$down_price_count,'',''];
        $exData = array_merge($exData,$total);
//        dump($exData);exit;
        Loader::import('XLSXWriter.xlsxwriter', EXTEND_PATH, '.class.php');
        $writer = new \XLSXWriter();
        //文件名
        $cur = '.';
        $path = '/uploads/order_port/';
        if (!is_dir($cur . $path)) {
            mkdir($cur . $path, 0777, true);
        }
        $filename = date('Y-m-d') . ".xls";
        //工作簿名称
        $sheet1 = 'sheet1';
        //浦发银行无需设置标题
        $title = [
            '店铺名称' => 'string',
            '淘宝号' => 'string',
            '淘宝订单' => 'string',
            '预付金额' => 'string',
            '实际下单金额' => 'string',
            '创建时间' => 'string',
            '状态' => 'string',
        ];
        $writer->writeSheetHeader($sheet1, $title); //每列的标题头
        foreach ($exData as $row) {
            $writer->writeSheetRow($sheet1, $row);
        }
        $allPath = $path . $filename;
        //$writer->writeToStdOut();
        $writer->writeToFile('.' . $allPath);
        $this->success('导出成功', $allPath);
    }
}