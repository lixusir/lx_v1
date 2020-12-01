<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"E:\wwwlog\lx_v1\public/../application/admin\view\workorder\index.html";i:1604024715;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
<div class="layui-fluid">
  <div class="layui-card">
    <div class="layui-form layui-card-header layuiadmin-card-header-auto">
      <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">工单号</label>
          <div class="layui-input-inline">
            <input type="text" name="word_id" placeholder="请输入工单号" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">工单标题</label>
          <div class="layui-input-inline">
            <input type="text" name="title" placeholder="请输入工单标题" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">受理人</label>
          <div class="layui-input-inline">
            <input type="text" name="accept_name" placeholder="请输入受理人名称" autocomplete="off" class="layui-input">
          </div>
        </div>
        <div class="layui-inline">
          <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="search">
            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="layui-card-body">
      <table id="list" lay-filter="list"></table>
    </div>
  </div>
</div>
<script type="text/html" id="barDemo">
  <a href="<?php echo url('WorkOrder/workEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
</script>
<script type="text/html" id="status">
  {{# if(d.status==1){ }}
  <button class="layui-btn layui-btn-warm layui-btn-xs">{{d.status_text}}</button>
  {{#  } else if(d.status==2) { }}
  <button class="layui-btn layui-btn-normal layui-btn-xs">{{d.status_text}}</button>
  {{#  } else if(d.status==0) { }}
  <button class="layui-btn layui-btn-xs">{{d.status_text}}</button>
  {{#  } }}
</script>
<script type="text/html" id="progressTpl">
  <div class="layui-progress layui-progress-big" lay-showPercent="yes">
    <div class="layui-progress-bar layui-bg-green" lay-percent="{{ d.speed }}%"></div>
  </div>
</script>
<script>
  layui.use(['index', 'table', 'form','element'], function () {
    var table = layui.table, form = layui.form,util = layui.util, $ = layui.jquery,r = (layui.form, layui.element)
    var tableIn = table.render({
              id: 'list',
              elem: "#list",
              url: '<?php echo url("WorkOrder/index"); ?>',
              method: 'post',
              cols: [[
                {type: "checkbox", fixed: "left"},
                {field: 'id', width: 80, title: 'ID'},
                {field: 'type_des', width: 160, title: '业务类型'},
                {field: 'title', width: 220, title: '工单标题'},
                {field: 'speed', width: 180, title: '进度',templet:"#progressTpl"},
                {field: 'user_name', width: 120, title: '提交者'},
                {field: 'accept_name', width: 120, title: '受理人员'},
                {field: 'accept_time', width: 160, title: '受理时间'},
                {field: 'status', width: 120, title: '工单状态', toolbar: "#status"},
                {field: 'create_time', width: 160, title: '提交时间'},
                {title: "操作",minWidth:230, align: "center", toolbar: "#barDemo"}
              ]],
              page: true,
              limit: 100,
              limits: [10, 40, 60, 80, 100],
              done:function(){r.render("progress")},
            }
    );
    //监听搜索
    form.on('submit(search)', function (data) {
      var field = data.field;
      //执行重载
      tableIn.reload({
        where: field
      });
    });
    //监听表格内的事件  如 编辑 删除等
    table.on('tool(list)', function (obj) {
      var data = obj.data;
      //删除
      if (obj.event === 'del') {
        layer.confirm('您确定要删除该内容吗？', function (index) {
          var loading = layer.load(1, {shade: [0.1, '#fff']});
          $.post("<?php echo url('workDel'); ?>", {id: data.id}, function (res) {
            layer.close(loading);
            if (res.code === 1) {
              layer.msg(res.msg, {time: 1000, icon: 1});
              table.reload('list');
            } else {
              layer.msg(res.msg, {time: 1000, icon: 2});
            }
          },'JSON');
          layer.close(index);
        });
      }
    });
  });
</script>
</body>
</html>



