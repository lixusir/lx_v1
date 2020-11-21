<?php
namespace app\model;
use think\Model;
class AccountLog extends Model{
     public function user(){
         return $this->belongsTo('Users','user_id');
     }
}
