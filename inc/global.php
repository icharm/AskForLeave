<?php

define("PATH_ROOT", dirname(dirname(__FILE__)));

//require_once PATH_ROOT."/inc/captcha.php";
require_once PATH_ROOT."/inc/function.php";
require_once PATH_ROOT."/inc/phpmail/function.php";
require_once PATH_ROOT."/inc/config.php";
require_once PATH_ROOT."/inc/Icharm_Db2.php";
require_once PATH_ROOT."/inc/JLAdmin.php";


date_default_timezone_set("PRC");

$g_userObj = new JLAdmin();

$g_user = $g_userObj->getCurrent();

$page = array(
	'title' => '南邮请销假系统',
	);