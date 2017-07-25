<?php
/**
 * @abstract 统一配置
 */

// url
define('GURL_ROOT', 'http://localhost/ask/');

// path
define('GPATH_ROOT', dirname(__FILE__));

// var
$gvarconf = array(
	'platform' => array(
		0 => 'wap',
		1 => 'ios',
		2 => 'android',
		3 => 'winphone',
		4 => 'pc',
	),
);

// db
$gdbconf = array(
	'ask' => array(
		'host' => '127.0.0.1',
		'port' => 3306,
		'username' => 'root',
		'password' => 'root',
		'dbname' => 'askforleave',
	),
);

// mail
$mailconf = array(
	'foxmail' => array(
		'host' => 'smtp.qq.com',
		'port' => 465,
		'secure' => 'ssl',	//加密方式
		'username' => 'icharm.me@foxmail.com',
		'password' => 'cjdvdeetatsydc', //qq授权码
		'formName' => '南邮请销假系统(ICHARM)', //显示在源邮件地址旁边的head
	),
);
