<?php
namespace app\model;
use think\Model;
class Order extends Model{
    public function user()
    {
        return $this->belongsTo('Users','user_id');
    }
}
