<?php

require_once("../inc/global.php");

$disc = trim($_POST['disc']);
$name = trim($_POST['name']);
$teacher = intval($_POST['teacher']);
if(!$name){
	echo returnMsg(0, "请输入课程名称", null);
	exit();
}
if(!$teacher){
	echo returnMsg(0, "请选择教师", null);
	exit();
}
if(!$disc){
	echo returnMsg(0, "请填写课程描述", null);
	exit();
}

$conn = icharm_db::factory("ask");

$user = new JLAdmin();

$sql = "SELECT * FROM `ask_class` WHERE `name`= :name";
$result = $conn->fetchRow($sql, array(':name'=>$name));

if($result){
	echo returnMsg(0, "课程已存在，请勿重复添加！");
	exit();
}

//插入数据
$data = array(
	'name' => $name,
	'teacher_id' => $teacher,
	'disc' => $disc,
	'date' => date("Y-m-d H:i:s"),
	);

$result = $conn->insert("ask_class", $data);

if($result)
	echo returnMsg(true, "添加成功", null);
else
	echo returnMsg(false, "系统繁忙，请稍后再试", null);
exit();