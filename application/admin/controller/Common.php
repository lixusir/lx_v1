<?php
namespace app\admin\controller;
class Common extends AdminBase{
    public function _initialize()
    {
        parent::_initialize(); //
    }

    public function head(){
        return $this->fetch();
    }
    public function foot(){
        return $this->fetch();
    }
    /*
     * 获取地区分类树
     */
    function getCityAreaTree(){
        $pid = input('provinceid');
        $cid = input('cityid');
        if(isset($pid) && !empty($pid)){
            $address = db('cities')->where(['provinceid'=>intval($pid)])->select();
            return $address;
        }
        if(isset($cid) && !empty($cid)){
            $address = db('areas')->where(['cityid'=>intval($cid)])->select();
            return $address;
        }
    }


}