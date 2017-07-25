<?php

require_once("inc/global.php");

//检查登录
$g_userObj->checkLogin();
//检查权限
if($g_user['power'] != 1){
	header('Location:'.GURL_ROOT.'login.php?backurl='.urlencode($_SERVER['REQUEST_URI']));
			exit;
}

$page = array(
	'title' => '管理员主页-南邮请销假系统',
	);


require_once("header.php");
?>

<div class="tpl-content-wrapper">
            










        </div>


<?php require("footer.php"); ?>
</body>

</html>