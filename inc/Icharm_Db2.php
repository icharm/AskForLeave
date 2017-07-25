<?php
/**
 * @abstract db
 */

class icharm_db {

	// instance
	protected static $instance = array();

	// 初始化
	public static function factory($app = 'default') {
		if (!array_key_exists($app, self::$instance)) {
			global $gdbconf;
			if (array_key_exists($app, $gdbconf)) {
				$var = $gdbconf[$app];
				$username = $var['username'];
				$password = $var['password'];				
				$dsn = 'mysql:host='.$var['host'].';port='.$var['port'].';dbname='.$var['dbname'];
				$obj = new _icharm_db($dsn, $username, $password); 
				self::$instance[$app] = $obj;
			} else {
				self::$instance[$app] = null;
				throw new Exception('db config not found');
			}
		}
		return self::$instance[$app];
	}
}

class _icharm_db{

	// 数据库链接
	protected $conn = null;

	// 操作执行数目
	protected $queryNum = 0;

	// 当前操作的sql
	protected $querySql = null;

	// 显示错误
	protected $debug = false;

	// 错误信息
	protected $error = array();

	/**
	 * 构造函数					
	 * @param [string] $dsn    主机信息
	 * @param [string] $username 数据库登录用户名
	 * @param [string] $password 密码
	 * @param array  $options  其他参数
	 */
	public function __construct($dsn, $username, $password, $options = array()) {
		try{
			$this->conn = new PDO($dsn, $username, $password);
			$this->conn->query('SET NAMES utf8');
		}catch(PDOException $exception){
			self::halt($exception->getMessage());

		}
	}

	/**
	 * 获取全部的数据
	 * @param  string $sql 数据库查询语句
	 * @param  array $param 查询语句中where参数
	 * @return array       返回查询结果,无结果返回false
	 */
	public function fetchRows($sql, $param = array(), $type=NULL){
		if(!$sql)
			return false;
		$tmp = $this->conn->prepare($sql);
		$tmp->execute($param);
		$result = $tmp->fetchAll($type);
		return $result;
	}

	/**
	 * 获取一条数据
	 * @param  string $sql  数据库查询语句
	 * @param  array $param 查询语句中where参数
	 * @param  string $type 返回结果形式，assoc返回查询结果的下一行，both返回查询结果的键值对和数字序号键值对，lazy只返回数据键值对
	 * @return array       查询结果集,无结果返回false
	 */
	public function fetchRow($sql, $param = array(), $type=NULL){
		if(!$sql)
			return false;
		$tmp = $this->conn->prepare($sql);
		$tmp->execute($param);
		$result = $tmp->fetch($type);
		return $result;
	}

	/**
	 * 插入一行数据
	 * @param  string  $tablename 数据表表名
	 * @param  array   $data      待插入数据的键值对
	 * @param  boolean $debug     是否开启调试,开启后再会在执行错误发生后打印错误信息，并返回false
	 * @return int             	  影响的行数
	 */	
	public function insert($tablename, $data = array(), $debug = false){
		if(!$tablename)
			return false;
		$keys = array();
		foreach ($data as $k => $v) {
			$keys[] = $k;
		}
		$query = "INSERT INTO `{$tablename}` (`".join("`,`", $keys)."`) VALUES (".':'.join(",:", $keys).")";
		$tmp = $this->conn->prepare($query);
		$param = array();
		foreach ($data as $key => $value){
			$param[":"."$key"] = $value;
		}	
		$result = $tmp->execute($param);
		if(!$result && $debug){
			print_r($this->conn->errorInfo());
			return false;
		}
		return $result;
	}

	/**
	 * 更新数据(不支持无条件更新所有数据)
	 * @param  string $tablename 数据表表名
	 * @param  array  $data      待更新数据
	 * @param  string $cond      WHERE语句后面的条件
	 * @param  int $limit        是否限制影响条数
	 * @return boolean	         成功true,失败false
	 */
	public function update($tablename, $data = array(), $cond, $limit = 1){
		if(!$tablename || !$data || !$cond)
			return false;
		$set = array();
		foreach ($data as $k => $v) {
			$set[] = "`{$k}`=:{$k}";
		}
		$param = array();
		foreach ($data as $key => $value) {
			$param[":"."$key"] = $value;
		}
		$query = "UPDATE `{$tablename}` SET ".join(',', $set)." WHERE {$cond}".($limit ? " LIMIT {$limit}" : '');
		$tmp = $this->conn->prepare($query);
		$result = $tmp->execute($param);
		return $result;
	}

	/**
	 * 删除数据
	 * @param  string $tablename 表名
	 * @param  array  $data      where条件里的参数
	 * @param  int $limit        是否限制影响条数
	 * @return boolean           成功true
	 */
	public function delete($tablename, $data = array(), $limit = null){
		if(!$tablename || !$data){
			return false;
		}

		$set = array();
		foreach ($data as $k => $v) {
			$set[] = "`{$k}`=:{$k}";
		}		
		$param = array();
		foreach ($data as $key => $value) {
			$param[":"."$key"] = $value;
		}

		$query = "DELETE FROM `{$tablename}` WHERE ".join(" AND ", $set).($limit?" LIMIT {$limit}": "");
		$tmp = $this->conn->prepare($query);
		$result = $tmp->execute($param);
		//print_r($this->conn->errorInfo());
		return $result;
	}

	/**
	 * @param  string str 错误信息
	 * @param  boolean $output 是否输出
	 * @return [type]
	 */
	public function halt($str = '', $output = true) {

		if (self::$debug && $output) {
			exit($str);
		} else {
			$str = date('Y-m-d H:i:s')."\t{$_SERVER['REQUEST_URI']}\n{$str}\n\n";
			file_put_contents('../log/db_error.log', $str, FILE_APPEND);
		}
	}

}