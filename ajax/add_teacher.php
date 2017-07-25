<?php

require_once("../inc/global.php");

$mail = trim($_POST['mail']);
$name = trim($_POST['name']);
if(!$mail){
	echo returnMsg(0, "请输入教师的邮箱", null);
	exit();
}
if(!$name){
	echo returnMsg(0, "请输入教师的名字", null);
	exit();
}

$conn = icharm_db::factory("ask");

$user = new JLAdmin();

$sql = "SELECT * FROM `ask_teacher` WHERE `mail`= :mail";
$result = $conn->fetchRow($sql, array(':mail'=>$mail));

if($result){
	echo returnMsg(0, "教师已存在，请勿重复添加！");
	exit();
}

//插入数据
$data = array(
	'name' => $name,
	'mail' => $mail,
	'date' => date("Y-m-d H:i:s"),
	);

$result = $conn->insert("ask_teacher", $data);

if($result)
	echo returnMsg(true, "添加成功", null);
else
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
exit();