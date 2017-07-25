<?php 

require_once("../inc/global.php");


$ac = intval($_POST['ac']);

if(!$ac){
	echo returnMsg(false, "系统繁忙，请稍后再试", null);exit();
}

switch ($ac) {
	case 1:
		$id = intval($_POST['id']);
		if(!$id){
			echo returnMsg(false, "系统繁忙，请稍后再试", null);exit();
		}
		$result = changeStatus(2, $id);
		//通知学生
		mailToStudent(true, $id);
		//通知老师
		mailToTeacher($id);
		break;

	case 2:
		$id = intval($_POST['id']);
		if(!$id){
			echo returnMsg(false, "系统繁忙，请稍后再试", null);exit();
		}
		$result = changeStatus(3, $id);
		mailToStudent(false, $id);
		break;
	
	default:
		$result = 0;
		break;
}
if($result){
	echo returnMsg(true, "Success", null);
}else{
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
}
exit();