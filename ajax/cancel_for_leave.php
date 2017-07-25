<?php

require_once("../inc/global.php");

$id = intval($_POST['id']);
if(!$id){
	echo returnMsg(false, "系统繁忙，请稍后再试", mull);
	exit();
}

//$conn = icharm_db::factory('ask');
//$result = $conn->delete("ask_leave_queue", array("id"=>$id), 1);
$result = changeStatus(5, $id);

if($result){
	echo returnMsg(true, "Success", null);
}else{
	echo returnMsg(false, "系统繁忙，请稍后再试", mull);
}exit();