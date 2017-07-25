<?php
require_once("../inc/global.php");

$who = intval($_POST['who']);
$id = intval($_POST['id']);

if(!$who || !$id){
	echo returnMsg(false, "系统繁忙，请稍后再试！", null);exit();
}

switch ($who) {
	case 1 :
		$result = deleteById("ask_teacher", $id);
		break;
	case 2 :
		$result = deleteById("ask_class", $id);
		break;
	case 3 :
		$result = deleteById("ask_mentor", $id);
		break;
	case 4 :
		$result = deleteById("ask_student", $id);
		break;
	default:
		$result = false;
		break;
}

if($result){
	echo returnMsg(true, "删除成功", null);exit;
}else{
	echo returnMsg(false, "系统繁忙，请稍后再试！", null);exit;
}

