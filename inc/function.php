<?php

/**
 * 验证 验证码是否正确
 * @param  string $code 验证码
 * @return boolean      正确返回true
 */	
function echoVerifyCode($code){
	if (!isset($_SESSION)) {
		session_start();
	}
	if(strtolower($code) == $_SESSION['authcode'])
		return true;
	else
		return false;
}

/**
 * 构建返回信息json格式
 * @param  boolean $flag 标志 1成功，0失败
 * @param  string $msg   相关信息
 * @param  array  $data  相关数据
 * @return string        json格式数据
 */
function returnMsg($flag,$msg,$data = array()){
	$ret = array(
			'flag' => $flag,
			'msg' => urlencode($msg),
			'data' => $data,
		);
	return urldecode(json_encode($ret));
}

/**
 * @param  string str 错误信息
 * @param  boolean $output 是否输出
 * @return [type]
 */
function saveLog($str = '',$path = '../log/record.log', $output = false) {

	if ($output) {
		exit($str);
	} else {
		$str = date('Y-m-d H:i:s')."\t{$_SERVER['REQUEST_URI']}\n{$str}\n\n";
		file_put_contents($path, $str, FILE_APPEND);
	}
}

/**
 * 检查手机号是否符合要求
 * @param  string $phone 手机号
 * @return boolean       true手机号正确
 */
function checkPhone($phone) {
	if (!preg_match('/^1[0-9]{10}$/', $phone)) {
		return false;
	}
	return true;
}

/**
 * 检查邮箱格式
 * @param  string $mail 邮箱地址
 * @return boolean      正确true
 */
function checkMail($mail){
	if(filter_var($mail, FILTER_VALIDATE_EMAIL))
		return true;
	else
		return false;
}

/**
 * 格式化打印数据
 * @param  All $data 待打印的数据
 * @return NULL       
 */
function varDump($data){
	echo "<pre>";var_dump($data);echo "<pre>"; 
}


/**
 * 匹配邮箱地址@前面的内容，返回出来
 * @param  string $mail 邮箱
 * @return string       
 */
function getNameFromMail($mail){
	//匹配邮箱@前面的内容
	preg_match('/(.*)@/i', $mail, $match);
	return  $match[1];
}




/**
 * 删除项
 * @param  string $tablename 
 * @param  int    $id        
 * @return boolean           
 */
function deleteById($tablename, $id){
	$conn = icharm_db::factory("ask");
	$result = $conn->delete($tablename, array('id'=>$id), 1);
	return $result;
}

function getStuInfo($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT p1.* , p2.name AS mentor_name  FROM `ask_student` p1 JOIN `ask_mentor` p2 ON p1.mentor_id = p2.id WHERE p1.student_id = :student_id";
	$result = $conn->fetchRow($sql , array(':student_id' => $id));
	return $result;
}

function getStuInfoById($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT *  FROM `ask_student` WHERE `id` = :id";
	$result = $conn->fetchRow($sql , array(':id' => $id));
	return $result;
}

function getMentorInfo($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT *   FROM `ask_mentor` WHERE `id` = :id";
	$result = $conn->fetchRow($sql , array(':id' => $id));
	return $result;
}

function getClassInfo($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT *   FROM `ask_class` WHERE `id` = :id";
	$result = $conn->fetchRow($sql , array(':id' => $id));
	return $result;
}

function getQueueInfo($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT *   FROM `ask_leave_queue` WHERE `id` = :id";
	$result = $conn->fetchRow($sql , array(':id' => $id));
	return $result;
}

function getTeacherInfo($id){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT *   FROM `ask_teacher` WHERE `id` = :id";
	$result = $conn->fetchRow($sql , array(':id' => $id));
	return $result;
}

function getClassList(){
	$conn = icharm_db::factory("ask");
	$sql = "SELECT * FROM `ask_class`";
	$result = $conn->fetchRows($sql);
	return $result;
}

function mailToMentor($data){
	$mentor = getMentorInfo($data['mentor_id']);
	$to = $mentor['mail'];
	$title = '新的请假审批';
	//$session = makeSessionForMentor();
	$content = "请点击链接，审批请假请求，".GURL_ROOT."mentor.php?key=".$data['mentor_id'];
	return sendMail($to, $title, $content, 'foxmail', false);

}


function mailToStudent($flag, $queue_id){
	$queue = getQueueInfo($queue_id);
	$student = getStuInfoById($queue['student_id']);
	$to = $student['mail'];
	$title = $flag?'审批通过':'审批被拒绝';
	$content = "亲爱的同学：\n".$student['name']."!\n您的请假".$title;
	return sendMail($to, $title, $content, 'foxmail', false);

}

function mailToTeacher($queue_id){
	$queue = getQueueInfo($queue_id);
	$student = getStuInfoById($queue['student_id']);
	$class = getClassInfo($queue['class_id']);
	$teacher = getTeacherInfo($class['teacher_id']);
	$to = $teacher['mail'];
	$title = '新的请假信息';
	$content = "亲爱的老师：\n".$student['name']."的请假信息如下：\n课程名：".$class['name']."\n开始时间：".$queue['start']."\n结束时间：".$queue['end']."\n请假理由：".$queue['reason'];
	return sendMail($to, $title, $content, 'foxmail', false);
}

function whichStatus($id){
	$data = array(
		1 => '待审核',
		2 => '审核通过',
		3 => '已拒绝',
		5 => '已销假',
		);
	return $data[$id]?$data[$id]:"UNKNOW";

}

function changeStatus($flag, $id){
	$conn = icharm_db::factory("ask");
	$result = $conn->update("ask_leave_queue", array('status' => $flag), "`id` = ".$id);
	return $result;
}
