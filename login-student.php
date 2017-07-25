<?php
require_once("inc/global.php");


?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>学生端-南邮请销假系统</title>
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
			<i>Student Log In </i> or <span> Sign Up</span>
		</div>
		<div class="am-u-sm-10 login-am-center">
			<form id="login" class="am-form">
				<fieldset>
					<div class="am-form-group">
						<input type="text" name="id" class="" id="student_id" placeholder="输入学号">
					</div>

					<p><a onclick="askforleave()" class="am-btn am-btn-default">请假</a></p>
          <p><a onclick="cancelforleave()" class="am-btn am-btn-default">销假</a></p>
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
  function askforleave(){

    var id = $("#student_id").val();
    if(!id){
      layer.alert("请输入学号", {icon : 2});
      return false;
    }
    window.location.href="ask-for-leave.php?id="+id;

  }

  function cancelforleave(){
    var id = $("#student_id").val();
    if(!id){
      layer.alert("请输入学号", {icon : 2});
      return false;
    }
    window.location.href="cancel-for-leave.php?id="+id;
  }

  </script>
</body>

</html>