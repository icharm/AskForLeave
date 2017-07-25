<?php
require_once("inc/global.php");

$id = trim($_GET['id']);
$stuInfo = getStuInfo($id);
//varDump($stuInfo);

$class = getClassList();
//varDump($class);

?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>学生端-南邮请销假系统</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css" />
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/amazeui.min.js"></script>
</head>

<body data-type="login">

  <div class="am-g myapp-login">
	<div class="myapp-login-logo-block  tpl-login-max">
		<div class="myapp-login-logo-text">
			<div class="myapp-login-logo-text">
				南邮请销假系统 <i class="am-icon-skyatlas"></i>
				
			</div>
		</div>

		<div class="login-font">
			<i>Ask For Leave </i> or <span> 请假 </span>
		</div>
		<div class="am-u-sm-10 login-am-center">
      <table class="am-table" style="color:white;">
        <tbody>
          <tr>
            <td>学号：</td>
            <td id="student_id"><?php echo $stuInfo['student_id']; ?></td>
          </tr>
          <tr>
            <td>姓名：</td>
            <td><?php echo $stuInfo['name']; ?></td>
          </tr>
          <tr>
            <td>辅导员：</td>
            <td><?php echo $stuInfo['mentor_name']; ?></td>
          </tr>
        </tbody>
      </table>
			<form  class="am-form">
				<fieldset>
          <span>&nbsp;</span>
          <div class="am-form-group" >
            <select data-am-selected="{maxHeight: 100, maxWidth: 220}" id="class">
              <option value="0" >请选择课程..</option>
               <?php foreach ($class as $value) { ?>
                  <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
               <?php } ?>
            </select>
          </div>

            <div class="am-alert am-alert-danger" id="my-alert" style="display: none">
              <p>开始日期应小于结束日期！</p>
            </div>
            <div class="am-form-group">
                <div class="am-g">
                  <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-margin-right" id="my-start">开始日期</button></div>
                  <div class="am-u-sm-6">
                    <span id="my-startDate" style="color:white"></span>
                  </div>
                </div>
            </div>
            <div class="am-form-group">
                <div class="am-g">
                  <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-margin-right" id="my-end">开始日期</button></div>
                  <div class="am-u-sm-6">
                    <span id="my-endDate" style="color:white"></span>
                  </div>
                </div>
            </div>
            <div class="am-form-group">
                <textarea id="reason" rows="5" style="border-radius: 6px;" placeholder="请编写请假理由"></textarea>
            </div>
					<p><a onclick="askforleave()" class="am-btn am-btn-default">提交审批</a></p>

				</fieldset>
			</form>
		</div>
	</div>
</div>


  <script src="assets/js/app.js"></script>
  <script src="assets/layer/layer.js"></script>
  <script type="text/javascript">
  var selectVal=0;
  $(document).ready(function(){
    if(!$("#student_id").text()){
      layer.alert("学号不存在！", {icon: 2}, function(){
        window.location.href="login-student.php";
      });
    }

    $(function() {
      var startDate = new Date();
      var endDate = new Date();
      var $alert = $('#my-alert');
      $('#my-start').datepicker().
        on('changeDate.datepicker.amui', function(event) {
            startDate = new Date(event.date);
            $('#my-startDate').text($('#my-start').data('date'));

          $(this).datepicker('close');
        });

      $('#my-end').datepicker().
        on('changeDate.datepicker.amui', function(event) {
          if (event.date.valueOf() < startDate.valueOf()) {
            $alert.find('p').text('结束日期应大于开始日期！').end().show();
          } else {
            $alert.hide();
            endDate = new Date(event.date);
            $('#my-endDate').text($('#my-end').data('date'));
          }
          $(this).datepicker('close');
        });
    });

    $("#class").on('change', function(){
      selectVal = $(this).val()
      //console.log();
    })
  })

  function askforleave(){
    var data = {};
    data.student_id = <?php echo $stuInfo['id']  ?> ;
    data.class_id = selectVal;
    data.mentor_id = <?php echo $stuInfo['mentor_id']  ?>;
    data.start_time = $('#my-startDate').text();
    data.end_time = $('#my-endDate').text();
    data.reason = $('#reason').val();
    console.log(data);

    if(data.class_id == 0){
      layer.alert("请选择请假课程!", {icon: 2});
      return false;
    }
    if(!data.start_time){
      layer.alert("请选择开始时间", {icon: 2});
      return false;
    }
    if(!data.end_time){
      layer.alert("请选择结束时间", {icon: 2});
      return false;
    }
    if(!data.reason){
      layer.alert("请填写请假理由", {icon: 2});
      return false;
    }

    $.ajax({
          'url':'ajax/add_ask_for_leave.php',
          'type':'post',
          'dataType':'json',
          'data':data,
          'success':function(ret){
            if(ret.flag){
              
              //询问框
              layer.alert('提交成功,已通知辅导员审批', {icon: 1}, function(){
                window.location.href="login-student.php";
              });

            }else{

              layer.alert(ret.msg, {icon: 2});
              return false;
            }
          },
          'error':function(ret){
            layer.alert("网络错误,请稍后再试！", {icon: 2});
            return false;
          },
        })

  }

  </script>
</body>

</html>