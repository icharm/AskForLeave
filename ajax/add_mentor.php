<?php

require_once("../inc/global.php");

$mail = trim($_POST['mail']);
$name = trim($_POST['name']);
$gender = intval($_POST['gender']);
if(!$name){
	echo returnMsg(0, "请输入辅导员的名字", null);
	exit();
}
if(!$mail){
	echo returnMsg(0, "请填写辅导员的邮箱", null);
	exit();
}

$conn = icharm_db::factory("ask");

$user = new JLAdmin();

$sql = "SELECT * FROM `ask_mentor` WHERE `mail`= :mail";
$result = $conn->fetchRow($sql, array(':mail'=>$mail));

if($result){
	echo returnMsg(0, "该辅导员已存在，请勿重复添加！");
	exit();
}

//插入数据
$data = array(
	'mail' => $mail,
	'gender' => $gender,
	'name' => $name,
	'date' => date("Y-m-d H:i:s"),
	);

$result = $conn->insert("ask_mentor", $data);

if($result)
	echo returnMsg(true, "辅导员添加成功", null);
else
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
exit();