<?php
/**
 * @abstract 登录处理类，移植需修改checkLogin函数和getByUsername函数
 */

class JLAdmin {

	// 名称
	protected static $sess_name = 'STOCK_USERS';
	// 有效期
	protected static $sess_life = 18000;

	// 验证
	public function checkLogin() {
		$admin = self::getCurrent();
		if (!$admin) {
			header('Location:'.GURL_ROOT.'login.php?backurl='.urlencode($_SERVER['REQUEST_URI']));
			exit;
		}
		return $admin;
	}

	// 获取当前登录
	public function getCurrent() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (!isset($_SESSION[self::$sess_name])) {
			return false;
		}
		$data = $_SESSION[self::$sess_name];
		if (time() - $data['time'] > self::$sess_life) {
			return false;
		}
		$value = json_decode($data['value'], true);
		return $value;
	}

	// 设置当前登录
	public function setCurrent($value) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$time = time();
		$data = array(
			'value' => json_encode($value),
			'time' => $time,
		);
		$_SESSION[self::$sess_name] = $data;
		return true;
	}

	// 退出当前登录
	public function outCurrent() {
		if (!isset($_SESSION)) {
			session_start();
		}
		unset($_SESSION[self::$sess_name]);
		return true;
	}

	// 验证加密密码
	public function checkPassword($password_ori, $password, $salt) {
		// $str1 = substr(md5($password_ori), 3, 16);
		// $str2 = substr(md5($salt), 1, -3);
		// $check = (md5($str1.$str2) == $password) ? true : false;
		// return $check;
		if($password ==$password_ori)
			return true;
		else
			return false;
	}

	// 生成加密密码
	public function makePassword($password_ori, $salt, $is_md5 = 0) {
		$str1 = substr($is_md5 ? $password_ori : md5($password_ori), 3, 16);
		$str2 = substr(md5($salt), 1, -3);
		$password = md5($str1.$str2);
		return $password;
	}

	// 生成加料散列
	public function makeSalt($length = 16) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$max = strlen($chars) - 1;
		$salt = '';
		for($i = 0; $i < $length; $i++) {
			$salt .= $chars[mt_rand(0, $max)];
		}
		return $salt;
	}

	// 获取用户
	public function getByUsername($mail) {
		$mail = trim($mail);
		if (!$mail) {
			return false;
		}
		$db = icharm_db::factory("stock");
		$sql = "SELECT * FROM ask_admin WHERE mail=:mail";
		$admin = $db->fetchRow($sql, array(':mail'=>$mail));
		if (!$admin) {
			return false;
		}
		return $admin;
	}
}