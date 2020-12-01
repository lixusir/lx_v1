<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"E:\wwwlog\lx_v1\public/../application/admin\view\index\index.html";i:1605941280;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\head.html";i:1604024720;s:55:"E:\wwwlog\lx_v1\application\admin\view\common\foot.html";i:1604024720;}*/ ?>
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
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="http://www.layui.com/admin/" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

          <li class="layui-nav-item" lay-unselect>
            <a lay-href="<?php echo url('Message/msgList'); ?>" layadmin-event="message" lay-text="消息中心">
              <i class="layui-icon layui-icon-notice"></i>
              <?php if($msg_count>0): ?>
              <span class="layui-badge-dot"></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;">
              <i class="layui-icon layui-icon-rmb"></i>&nbsp;可用余额：<?php echo $user_money; ?>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite><?php echo \think\Session::get('admin_name'); ?></cite>
            </a>
            <dl class="layui-nav-child">
              <dd><a lay-href="set/user/password.html">修改密码</a></dd>
              <hr>
              <dd id="logout" style="text-align: center;"><a>退出</a></dd>
            </dl>
          </li>

          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="abouts"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>

      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="home/console.html">
            <span>平台端管理</span>
          </div>

          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <?php if(is_array($sys_rule) || $sys_rule instanceof \think\Collection || $sys_rule instanceof \think\Paginator): $i = 0; $__LIST__ = $sys_rule;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="<?php echo $vo['name']; ?>" lay-direction="2">
                <i class="layui-icon <?php echo $vo['icon']; ?>"></i>
                <cite><?php echo $vo['name']; ?></cite>
              </a>
              <?php if(isset($vo['level'])): ?>
              <dl class="layui-nav-child">
                <?php if(is_array($vo['level']) || $vo['level'] instanceof \think\Collection || $vo['level'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['level'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvo): $mod = ($i % 2 );++$i;?>
                <dd data-name="">
                  <a lay-href="<?php echo url($vvo['link']); ?>"><?php echo $vvo['name']; ?></a>
                </dd>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </dl>
              <?php endif; ?>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home/console.html" lay-attr="<?php echo url('Index/console'); ?>" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>

      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="<?php echo url('Index/console'); ?>" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>

      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>
<?php if($msgIsNo>0): ?>
<input type="hidden" id="msg_title" value="<?php echo $msgNoInfo['title']; ?>" />
<input type="hidden" id="msg_id" value="<?php echo $msgNoInfo['id']; ?>" />
<div id="msg_content" style="display:none;">
  <div style="padding:20px;"><?php echo $msgNoInfo['content']; ?></div>
</div>
<?php endif; ?>
<script>
  layui.use(['form', 'layer'], function () {
    var form = layui.form, $ = layui.jquery,layer = layui.layer;
    $("#logout").on('click',function(){
         $.post("<?php echo url('Index/logout'); ?>",function(res){
               layer.msg(res.msg,{time:1500,icon:1},function(){
                   window.location.href=res.url;
               });
         });
    });
    //消息弹窗
    var isNo = "<?php echo $msgIsNo; ?>";
    if(isNo>0){
      var w=($(window).width()*0.6);
      var h=($(window).height() - 300);
      var msg_tit = $("#msg_title").val();
      var msg_id = $("#msg_id").val();
      layer.open({
        type: 1
        ,title:msg_tit
        ,area: [w+'px', h +'px']
        ,id: 'message'
        ,content: $("#msg_content")
        ,btn: '关闭不再显示'
        ,btnAlign: 'c' //按钮居中
        ,shade: 0 //不显示遮罩
        ,yes: function(){
          $.post("<?php echo url('Message/setMsgStatus'); ?>", {ids: msg_id}, function (data) {
            if (data.code === 1) {
              layer.closeAll();
            } else {
              layer.msg(data.msg, {time: 1000, icon: 2});
            }
          });
        }
      });
    }

  });
</script>
</body>
</html>





