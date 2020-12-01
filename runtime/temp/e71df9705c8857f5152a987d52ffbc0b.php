<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"E:\wwwlog\lx_v1\public/../application/admin\view\login\index.html";i:1604024715;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>登录-管理系统</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="/static/layuiadmin/style/login.css" media="all">
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
<body>
  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>平台管理后台</h2>
        <p>Welcome to the management system</p>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="user_name" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
              <input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
            </div>
            <div class="layui-col-xs5">
              <div style="margin-left: 10px;">
                <img src="<?php echo captcha_src(); ?>" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode" onclick="this.src='/captcha.html?d='+Math.random();">
              </div>
            </div>
          </div>
        </div>
        <div class="layui-form-item" style="margin-bottom: 20px;">
<!--          <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">-->
<!--          <a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>-->
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="submit" id="submit">登 入</button>
        </div>
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      
      <p>© 2019 <a href="/" target="_blank">ditui.com</a></p>
      <p>
        <span><a href="/" target="_blank">商家端</a></span>
        <span><a href="/" target="_blank">业务员端</a></span>
      </p>
    </div>
  </div>
  <script>
    layui.use(['form', 'layer'], function () {
      var form = layui.form, $ = layui.jquery;
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
            if(res.msg=='验证码错误，请重新输入'){
              var code_url = '/captcha.html?d='+Math.random()
                $("#LAY-user-get-vercode").attr('src',code_url);
            }
            layer.msg(res.msg, {time: 1800, icon: 2});
          }
        });
      });
      $(document).on('keydown', function(e){
        if(e.keyCode == 13){
          $("#submit").click();
        }
      });
    });
  </script>
</body>
</html>