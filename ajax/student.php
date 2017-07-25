<?php
require_once("../inc/global.php");

$ac = intval($_POST['ac']);
$stuInfo = getStuInfo($id);

if(!$ac){
	echo returnMsg(false, "系统繁忙，请稍后再试！", null);exit();
}

switch ($ac) {
	case 1 :

		break;
	case 2 :

		break;
	case 3 :

		break;
	case 4 :

		break;
	default:
		$result = false;
		break;
}



