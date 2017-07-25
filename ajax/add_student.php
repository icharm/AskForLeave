<?php

require_once("../inc/global.php");

$mail = trim($_POST['mail']);
$name = trim($_POST['name']);
$id = trim($_POST['id']);
$mentor = trim($_POST['mentor']);
$gender = intval($_POST['gender']);
if(!$name){
	echo returnMsg(0, "请输入学生姓名", null);
	exit();
}
if(!$gender){
	echo returnMsg(0, "请选择性别", null);
	exit();
}
if(!$mentor){
	echo returnMsg(0, "请选择辅导员", null);
	exit();
}
if(!$id){
	echo returnMsg(0, "请输入学号", null);
	exit();
}
if(!$mail){
	echo returnMsg(0, "请输入学生邮箱", null);
	exit();
}

$conn = icharm_db::factory("ask");

$user = new JLAdmin();

$sql = "SELECT * FROM `ask_student` WHERE `id`= :id";
$result = $conn->fetchRow($sql, array(':id'=>$id));

if($result){
	echo returnMsg(0, "该学生已存在，请勿重复添加！");
	exit();
}

//插入数据
$data = array(
	'name' => $name,
	'mail' => $mail,
	'student_id' => $id,
	'mentor_id' => $mentor,
	'gender' => $gender,
	'date' => date("Y-m-d H:i:s"),
	);

$result = $conn->insert("ask_student", $data);

if($result)
	echo returnMsg(true, "添加成功", null);
else
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
exit();