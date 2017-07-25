<?php
require_once("inc/global.php");

$user = new JLAdmin();

//登出
if($_GET['action'] == 'out'){
    $user->outCurrent();
    header('Location:'.GURL_ROOT.'login.php');
    exit;
}

//已登录处理
$g_admin = $user->getCurrent();
if($g_admin){
    header('Location:'.GURL_ROOT.'index.php');
    exit;
}

//是否跳转来源页
$backurl = trim($_GET['backurl']);
if($backurl){
  $backFlag = 1;
}else{
  $backFlag = 2;
}

?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>南邮请销假系统-登录</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css" />
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/app.css">
</head>

<body data-type="login">

  <div class="am-g myapp-login">
	<div class="myapp-login-logo-block  tpl-login-max">
		<div class="myapp-login-logo-text">
			<div class="myapp-login-logo-text">
				南邮请销假系统 <i class="am-icon-skyatlas"></i>
				
			</div>
		</div>

		<div class="login-font">
			<i>Log In </i> or <span> Sign Up</span>
		</div>
		<div class="am-u-sm-10 login-am-center">
			<form id="login" class="am-form">
				<fieldset>
					<div class="am-form-group">
						<input type="email" name="mail" class="" id="doc-ipt-email-1" placeholder="输入电子邮件">
					</div>
					<div class="am-form-group">
						<input type="password" name="pwd" class="" id="doc-ipt-pwd-1" placeholder="输入个密码吧">
					</div>
					<p><a onclick="login()" class="am-btn am-btn-default">登录</a></p>
				</fieldset>
			</form>
		</div>
	</div>
</div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/amazeui.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script src="assets/layer/layer.js"></script>
  <script type="text/javascript">
      function login(){
        data = {};
        data = $('#login').serialize();
        // // console.log(data);
        // if(!$()mail){
        //   layer.alert('请输入用户名（邮箱）！', {icon: 1});
        //   return false;
        // }
        // if(!data.pwd){
        //   layer.alert('请输入密码', {icon: 1});
        //   return false;
        // }

        $.ajax({
          'url':'ajax/login.php',
          'type':'post',
          'dataType':'json',
          'data':data,
          'success':function(ret){
            if(ret.flag){
              layer.alert("Login Success", {icon: 1});
              if(1 == <?php echo $backFlag;?>){
                window.location.href = "<?php echo $backurl;?>"
              }else{
                window.location.href='index.php';
              }
            }else{
              layer.alert(ret.msg, {icon: 2});
              return false;
            }
          },
          'error':function(ret){
            layer.alert("网络错误,请稍后再试！", {icon: 2});
            return false;
          },
        })
        return true;
      }	

  </script>
</body>

</html>