<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"E:\wwwlog\lx_v1\public/../application/admin\view\system\rule_edit.html";i:1604024717;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
        <legend>规则添加/编辑</legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-tab-content">
            <div class="layui-form-item">
                <label class="layui-form-label">所属上级</label>
                <div class="layui-input-4">
                    <select name="pid">
                        <option value=''>请选择</option>
                        <?php if(is_array($rule) || $rule instanceof \think\Collection || $rule instanceof \think\Paginator): $i = 0; $__LIST__ = $rule;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>" <?php if($info['pid']==$vo['id']): ?>selected<?php endif; ?>><?php echo $vo['space']; ?>|--<?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux red">留空为顶级类目</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-4">
                    <input type="text" name="name" value="<?php echo $info['name']; ?>" class="layui-input" lay-verify="required" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">类型</label>
                <div class="layui-input-4">
                    <select lay-verify="required" name="type">
                        <option value=''>请选择<?php echo $info['type']; ?></option>
                        <?php if(is_array($linkage['type']) || $linkage['type'] instanceof \think\Collection || $linkage['type'] instanceof \think\Paginator): $i = 0; $__LIST__ = $linkage['type'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $key; ?>" <?php if($info['type'] ==$key): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">链接</label>
                <div class="layui-input-4">
                    <input type="text" name="link" value="<?php echo $info['link']; ?>" lay-verify="required" placeholder="" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux red">控制器与操作方法,例：System/index</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">ICON名称</label>
                <div class="layui-input-4">
                    <input type="text" name="icon" value="<?php echo $info['icon']; ?>" placeholder="" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux red">图标样式的名称</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-4">
                    <input type="text" name="sort" value="<?php echo (isset($info['sort']) && ($info['sort'] !== '')?$info['sort']:50); ?>" placeholder="" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否展开</label>
                <div class="layui-input-4">
                    <?php if(is_array($linkage['spread']) || $linkage['spread'] instanceof \think\Collection || $linkage['spread'] instanceof \think\Paginator): $i = 0; $__LIST__ = $linkage['spread'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="radio" name="spread" value="<?php echo $key; ?>" title="<?php echo $vo; ?>" lay-verify="required" <?php if($info['spread']==$key): ?>checked<?php elseif($key==0): ?>checked<?php endif; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="layui-form-mid layui-word-aux red">菜单是否展开</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-4">
                    <?php if(is_array($linkage['status']) || $linkage['status'] instanceof \think\Collection || $linkage['status'] instanceof \think\Paginator): $i = 0; $__LIST__ = $linkage['status'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <input type="radio" name="status" value="<?php echo $key; ?>" title="<?php echo $vo; ?>" lay-verify="required" <?php if($info['status']==$key): ?>checked<?php elseif($key==1): ?>checked<?php endif; ?>>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="id" value="<?php echo $info['id']; ?>"/>
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
                <a href="<?php echo url('System/ruleList'); ?>" class="layui-btn layui-btn-primary">返回列表</a>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'layer', 'upload'], function () {
        var form = layui.form, $ = layui.jquery, upload = layui.upload;
        //提交
        form.on('submit(submit)', function (data) {
            loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("", data.field, function (res) {
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


