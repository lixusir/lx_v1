<?php
namespace app\cron\controller;
use app\model\Task as taskModel;
use think\Controller;
class Tasks extends Controller{
    /*
     * 生成任务单
     */
    public function createTaskOrder(){
        $config = db('SystemConfig')->find(1);
        $unite = $config['task_unite'];
        $taskModel = new taskModel();
        $result = $taskModel->doCreateTask($unite);
        dump($result);exit;
        if(isset($result['code']) && $result['code']!=200){
            $this->error($result['msg']);
        }
        $this->success('操作成功',url('Task/taskList'));
    }
}