<?PHP
/**
 * @abstract SMTP邮件发送函数、配置函数
 */
require_once("phpmailer/PHPMailerAutoload.php"); 
//require_once("../global.php");

/**
 * 发送SMTP邮件
 * @param  string  $to      目的邮箱地址
 * @param  string  $title   邮件标题
 * @param  string  $content 邮件正文
 * @param  string  $conf    发送服务器配置文件
 * @param  boolean $is_HTML 是否为HTML邮件
 * @return boolean          成功返回true,失败返回false
 */	
function sendMail($to, $title ,$content, $conf ,$is_HTML = false){

	//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告

	//示例化PHPMailer核心类
	$mail = new PHPMailer();
	global $mailconf;
	//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
	$mail->SMTPDebug = 0; 
	//使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
	//可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
	$mail->isSMTP();
	//smtp需要鉴权 这个必须是true
	$mail->SMTPAuth=true;
	//链接qq域名邮箱的服务器地址
	$mail->Host = $mailconf[$conf]['host'];
	//设置使用ssl加密方式登录鉴权
	$mail->SMTPSecure = $mailconf[$conf]['secure'];
	//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
	$mail->Port = $mailconf[$conf]['port'];
	//设置smtp的helo消息头 这个可有可无 内容任意
	$mail->Helo = 'Hello smtp.qq.com Server';
	//设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
	$mail->Hostname = GURL_ROOT;
	//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
	$mail->CharSet = 'UTF-8';
	//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
	$mail->FromName = $mailconf[$conf]['formName'];
	//smtp登录的账号 这里填入字符串格式的qq号即可
	$mail->Username =$mailconf[$conf]['username'];
	//smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
	$mail->Password =$mailconf[$conf]['password'];
	//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
	$mail->From = $mailconf[$conf]['username'];
	//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
	$mail->isHTML($is_HTML); 
	//设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
	$mail->addAddress($to, NULL);
	//添加多个收件人 则多次调用方法即可
	//$mail->addAddress('xxx@163.com','晶晶在线用户');
	//添加该邮件的主题
	$mail->Subject = $title;
	//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
	$mail->Body = $content;
	//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
	//$mail->addAttachment('./d.jpg','mm.jpg');
	//同样该方法可以多次调用 上传多个附件
	//$mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
	 
	 
	//发送命令 返回布尔值 
	//PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
	$status = $mail->send();
	 
	//简单的判断与提示信息
	if($status) {
	 	return true;
	}else{
		return false;
	 //echo '发送邮件失败，错误信息未：'.$mail->ErrorInfo;
	}
}


function buildHtmlMail(){
	$content = file_get_contents("mailtemplate.tpl");
	$to = "952483995@qq.com";
	$title="涨幅通知-股票预警";
	$result = sendMail($to,$title,$content,"51blogs",true);
	var_dump($result);
}

function sendMailVerify($to, $username, $url){
	$content = file_get_contents(GURL_ROOT."inc/phpmail/mailVerify.tpl");
	$title = "账号激活-股票预警";
	$content = str_replace("{username}", $username, $content);
	$content = str_replace("{verifyurl}", $url, $content);
	$result = sendMail($to, $title, $content, "51blogs",true);
	return $result;
}

function sendRisingNotice($param = array()){
	$content = file_get_contents(GURL_ROOT."inc/phpmail/RisingNoticeTemplate.tpl");
	$content = str_replace("{username}", $param[2], $content);
	$content = str_replace("{header}", $param[3], $content);
	$content = str_replace("{stockname}", $param[4], $content);
	$content = str_replace("{stockcode}", $param[5], $content);
	$content = str_replace("{pricenow}", $param[6], $content);
	$content = str_replace("{pricehope}", $param[7], $content);
	$content = str_replace("{raise}", $param[8], $content);
	$content = str_replace("{raisenow}", $param[9], $content);
	$content = str_replace("{kaipanprice}", $param[10], $content);
	$content = str_replace("{maxprice}", $param[11], $content);
	$content = str_replace("{datetime}", $param[12], $content);

	$result = sendMail($param[0],$param[1], $content, "51blogs", true);
	return $result;
}

function sendDropNotice($param = array()){
	$content = file_get_contents(GURL_ROOT."inc/phpmail/DropNoticeTemplate.tpl");
	$content = str_replace("{username}", $param[2], $content);
	$content = str_replace("{header}", $param[3], $content);
	$content = str_replace("{stockname}", $param[4], $content);
	$content = str_replace("{stockcode}", $param[5], $content);
	$content = str_replace("{pricenow}", $param[6], $content);
	$content = str_replace("{pricehope}", $param[7], $content);
	$content = str_replace("{raise}", $param[8], $content);
	$content = str_replace("{raisenow}", $param[9], $content);
	$content = str_replace("{kaipanprice}", $param[10], $content);
	$content = str_replace("{maxprice}", $param[11], $content);
	$content = str_replace("{datetime}", $param[12], $content);

	$result = sendMail($param[0],$param[1], $content, "51blogs", true);
	return $result;
}