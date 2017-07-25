<?php

require_once("../inc/global.php");

$mail = trim($_POST['mail']);
$pwd = trim($_POST['pwd']);


if(!$mail){
	echo returnMsg(0, "please input mail!", null);
	exit();
}
if(!$pwd){
	echo returnMsg(0, "please input password!", null);
	exit();
}

$conn = icharm_db::factory("ask");

$user = new JLAdmin();

$sql = "SELECT * FROM `ask_admin` WHERE `mail`= :mail";
$result = $conn->fetchRow($sql, array(':mail'=>$mail));

if(!$result){
	echo returnMsg(0, "Unkown Account !");
	exit();
}
//验证密码
if(!$user->checkPassword($pwd, $result['password'], $result['salt'])){
	echo returnMsg(0," Error Password !");
	exit();
}

//设置为登录状态
$user->setCurrent($result);

echo returnMsg(true, "Login Success", null);