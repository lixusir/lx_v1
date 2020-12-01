<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"E:\wwwlog\lx_v1\public/../application/admin\view\money\money_list.html";i:1604024716;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
                    <label class="layui-form-label">统计时间</label>
                    <div class="layui-input-inline">
                        <input type="text" id="time" name="time" placeholder="请选择统计时间"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <input type="text" name="plan_id" placeholder="请输入计划编号" class="layui-input">
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

<script type="text/html" id="cert_pic">
    {{# if(d.cert_pic){ }}
    <a target="_blank" href="{{d.cert_pic}}"><img style="display: inline-block; width: 50%; height: 100%;"
                                                  src="{{d.cert_pic}}"/></a>
    {{#  } else { }}
    <img src="/static/common/images/image.gif"/>
    {{# } }}
</script>

<script type="text/html" id="exc_money">
    {{# if(d.operate ==1){ }}
    +{{d.exc_money}}
    {{#  } else if(d.operate ==2) { }}
    -{{d.exc_money}}
    {{#  } }}
</script>

<script>
    layui.use(['index', 'table', 'form', 'laydate'], function () {
        var table = layui.table, form = layui.form, $ = layui.jquery;
        var laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#time'
            , range: true
        });
        var tableIn = table.render({
                id: 'tpl',
                elem: "#list",
                url: '<?php echo url("Money/moneyList"); ?>',
                method: 'post',
                cols: [[
                    {field: 'desc', title: '变更原因'},
                    {field: 'old_money', title: '原余额'},
                    {field: 'exc_money', title: '操作金额', toolbar: "#exc_money"},
                    {field: 'user_money', title: '变更后余额'},
                    {field: 'create_time', minWidth: 180, title: '变更时间'},
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

    });
</script>
</body>
</html>


