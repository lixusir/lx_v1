<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"E:\wwwlog\lx_v1\public/../application/admin\view\system\commission.html";i:1604024716;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>地推系统后台管理系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="/static/layuiadmin/style/style.css" media="all">
  <script src="/static/layuiadmin/layui/layui.js"></script>
  <script>
    layui.config({
      base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
      index: 'lib/index' //主入口模块
    }).use('index');
  </script>
</head>
<body class="layui-layout-body">
<div class="admin-main fadeInUp animated">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>佣金设置</legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">商家佣金</li>
                <?php if(\think\Session::get('admin_id')==1): ?>
                <li class="">粉丝佣金</li>
                <li class="">好评佣金</li>
                <?php endif; ?>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <?php if(is_array($commission[2]) || $commission[2] instanceof \think\Collection || $commission[2] instanceof \think\Paginator): if( count($commission[2])==0 ) : echo "" ;else: foreach($commission[2] as $key=>$item): ?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo $item['name']; ?></label>
                        <div class="layui-input-2">
                            <input type="text" name="comm[<?php echo $item['id']; ?>]" value="<?php echo $item['val']; ?>" placeholder="请输入佣金金额"  class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux red">
                            元
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <?php if(\think\Session::get('admin_id')==1): ?>
                <div class="layui-tab-item">
                    <?php if(is_array($commission[1]) || $commission[1] instanceof \think\Collection || $commission[1] instanceof \think\Paginator): if( count($commission[1])==0 ) : echo "" ;else: foreach($commission[1] as $key=>$item): ?>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo $item['name']; ?></label>
                        <div class="layui-input-2">
                            <input type="text" name="comm[<?php echo $item['id']; ?>]" value="<?php echo $item['val']; ?>" placeholder="请输入佣金金额"  class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux red">
                            元
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="layui-tab-item">
                    <div class="layui-form-item">
                        <label style="width: 160px;" class="layui-form-label">指定好评刷手佣金</label>
                        <div class="layui-input-2">
                            <input type="text" name="user_comment_money" value="<?php echo (isset($config['user_comment_money']) && ($config['user_comment_money'] !== '')?$config['user_comment_money']:1); ?>" placeholder="指定好评刷手佣金"  class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux red">
                            元 &nbsp;&nbsp; 完成好评后，刷手获得奖励
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label style="width: 160px;" class="layui-form-label">指定好评商家佣金</label>
                        <div class="layui-input-2">
                            <input type="text" name="seller_comment_money" value="<?php echo (isset($config['seller_comment_money']) && ($config['seller_comment_money'] !== '')?$config['seller_comment_money']:3); ?>" placeholder="指定好评商家佣金"  class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux red">
                            元 &nbsp;&nbsp; 商家指定好评需扣除的佣金
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">确定保存</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'layer', 'laydate','upload'], function () {
        var form = layui.form, $ = layui.jquery, laydate = layui.laydate,upload = layui.upload;
        //提交模板
        form.on('submit(submit)', function (data) {
            loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('System/Commission'); ?>", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {icon: 1, time: 1000}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });

    });
</script>
</body>
</html>


