<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"E:\wwwlog\lx_v1\public/../application/admin\view\message\msg_list.html";i:1604024718;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
      <div class="layui-card-header layuiadmin-card-header-auto">
        <a class="layui-btn" href="<?php echo url('Message/msgEdit'); ?>">添加公告</a>
      </div>
      <div class="layui-card-body">
        <table id="list" lay-filter="list"></table>
      </div>
    </div>
  </div>
<script type="text/html" id="barDemo">
  <a href="<?php echo url('Message/msgEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>
<script type="text/html" id="nameDesc">

</script>
  <script>
    layui.use(['index', 'table', 'form','util'], function () {
      var table = layui.table, form = layui.form,util = layui.util, $ = layui.jquery;
      var tableIn = table.render({
              id: 'list',
              elem: "#list",
              url: '<?php echo url("Message/msgList"); ?>',
              method: 'post',
              cols: [[
                {type: "checkbox", fixed: "left"},
                {field: "title", title: "标题", minWidth: 150},
                {field: "plat_des", width: 100, title: "发布平台"},
                {field: "type_des", width: 100, title: "公告类型"},
                {field: "url", width: 200, title: "公告链接"},
                {field: "begin_time",width:160, title: "开始时间"},
                {field: "end_time",width:160, title: "结束时间"},
                {field: 'create_time', width: 200, title: '添加时间'},
                {field: 'status_des', width: 140, title: '状态'},
                {title: "操作", minWidth:230, align: "center", toolbar: "#barDemo"}
              ]],
              page: true,
              limit: 100,
              limits: [10, 40, 60, 80, 100],
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
            $.post("<?php echo url('msgDel'); ?>", {id: data.id}, function (res) {
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



