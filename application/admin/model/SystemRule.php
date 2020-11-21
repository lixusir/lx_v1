<?php
namespace app\admin\model;
use think\Model;
class SystemRule extends Model{
//     public function getTypeAttr($value){
//           $linkage = linkage('rule')['type'];
//           return $linkage[$value];
//     }
    public function getSpreadAttr($value){
        $linkage = linkage('rule')['spread'];
        return $linkage[$value];
    }
    public function getStatusAttr($value){
        $linkage = linkage('rule')['status'];
        return $linkage[$value];
    }
}
