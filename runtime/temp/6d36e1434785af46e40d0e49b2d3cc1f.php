<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"E:\wwwlog\lx_v1\public/../application/admin\view\system\rule_list.html";i:1605942302;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
        <a class="layui-btn" href="<?php echo url('System/ruleEdit'); ?>">添加规则</a>
      </div>
      <div class="layui-card-body">
        <table id="list"></table>
      </div>
    </div>
  </div>
<script type="text/html" id="barDemo">
  <a href="<?php echo url('System/ruleEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>编辑</a>
  <a href="<?php echo url('System/ruleDel'); ?>?id={{d.id}}" class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>
<script type="text/html" id="typeDesc">
  {{# if(d.type==1){ }}
  菜单
  {{# }else{ }}
  按钮
  {{# } }}
</script>
<script type="text/html" id="nameDesc">
  {{d.space}}|--{{d.name}}
</script>
  <script>
    layui.use(['index', 'table', 'form','util'], function () {
      var table = layui.table, form = layui.form,util = layui.util, $ = layui.jquery;
      var tableIn = table.render({
              id: 'list',
              elem: "#list",
              url: '<?php echo url("System/ruleList"); ?>',
              method: 'post',
              cols: [[
                {type: "checkbox", fixed: "left"},
                {field: 'id', width: 80, title: 'ID'},
                {field: 'name', width: 260, title: '名称',toolbar:'#nameDesc'},
                {field: 'link', width: 220, title: '链接'},
                {field: 'type', width: 100, title: '类型',toolbar:"#typeDesc"},
                {field: 'pid', width: 120, title: 'pid'},
                {field: 'spread', width: 120, title: '是否展开'},
                {field: 'status', width: 120, title: '状态'},
                {field: 'sort', width: 100, title: '排序'},
                {field: 'create_time', width: 200, title: '添加时间'},
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
      var active = {
        add: function(){
          layer.open({
            type: 2
            ,title: '添加规则'
            ,content: "<?php echo url('System/ruleEdit'); ?>"
            ,area: ['650px', '500px']
            ,btn: ['确定', '取消']
            ,yes: function(index, layero){
              var othis = layero.find('iframe').contents().find("#layuiadmin-app-form-tags")
                      ,tags = othis.find('input[name="tags"]').val();

              if(!tags.replace(/\s/g, '')) return;

              table.reload('LAY-app-content-tags');
              layer.close(index);
            }
          });
        }
      }
      $('.layui-btn.layuiadmin-btn-tags').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
      });
    });
  </script>
</body>
</html>



