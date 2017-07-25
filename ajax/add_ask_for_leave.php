<?php

require_once("../inc/global.php");

$student_id= intval($_POST['student_id']);
$class_id = intval($_POST['class_id']);
$mentor_id = intval($_POST['mentor_id']);
$start_time = trim($_POST['start_time']);
$end_time = trim($_POST['end_time']);
$reason = trim($_POST['reason']);


$conn = icharm_db::factory("ask");

//插入数据
$data = array(
	'student_id' => $student_id,
	'class_id' => $class_id,
	'mentor_id' => $mentor_id,
	'start' => $start_time,
	'end' => $end_time,
	'reason' => $reason,
	'status' => 1,
	'date' => date("Y-m-d H:i:s"),
	);
//varDump($data);
$result = $conn->insert("ask_leave_queue", $data);

if($result){
	//通知辅导员
	//
	$send = mailToMentor($data);
	echo returnMsg(true, "Success", null);
}else
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
exit();