<?php
require_once("inc/global.php");

$id = trim($_GET['id']);
$stuInfo = getStuInfo($id);
//varDump($stuInfo);

//$class = getClassList();
//varDump($class);

$conn = icharm_db::factory('ask');

$sql = "SELECT p1.* , p2.name AS class_name FROM `ask_class` p2 JOIN (SELECT t1.* ,t2.name AS student_name FROM `ask_leave_queue` t1 JOIN `ask_student` t2 ON t1.student_id = t2.id WHERE t1.student_id = :student_id) p1 ON p1.class_id = p2.id";
$leave = $conn->fetchRows($sql, array(':student_id'=>$stuInfo['id']));
//var_dump($leave);
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
      <i>Ask For Leave </i> or <span> 销假 </span>
    </div>
    <div class="am-u-sm-10 login-am-center">
      <table class="am-table" style="color:white;">
        <thead>
          <tr>
          <th class="table-check"><input type="checkbox" class="tpl-table-fz-check"></th>
            <th class="table-type">序号</th>
            <th class="table-type">请假课程</th>
            <th class="table-type">开始时间</th>
            <th class="table-type">结束时间</th>
            <th class="table-type">请假原因</th>
            <th class="table-type">状态</th>
            <!-- <th class="table-author am-hide-sm-only">作者</th> -->
            <th class="table-date am-hide-sm-only">修改时间</th>
            <th class="table-set">操作</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach($leave as $k => $v){ ?>

            <tr id="<?php echo $v['id']; ?>">
                <td><input type="checkbox"></td>
                <td><?php echo $k; ?></td>
                <td><?php echo $v['class_name']; ?></td>
                <td><?php echo $v['start']; ?></td>
                <td><?php echo $v['end']; ?></td>
                <td><?php echo $v['reason']; ?></td>
                <td id="status<?php echo $v['id']; ?>" ><?php echo whichStatus($v['status']); ?></td>
                <td class="am-hide-sm-only"><?php echo $v['date']; ?></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                          <a onclick="ask_cancel(<?php echo $v['id'] ?>)" class="am-btn am-btn-default am-btn-xs am-text-secondary"> 销假 </a>
                        </div>
                    </div>
                </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


  <script src="assets/js/app.js"></script>
  <script src="assets/layer/layer.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){

   
  })

  function ask_cancel(id){
    data = {};
    data.id = id;
    $status = $("#status"+data.id).text()
    if($status == "已销假" || $status == "已拒绝"){
      layer.alert('该条请假数据不可更改!', {icon: 2});
      return false;
    }
    layer.msg('加载中', {
            icon: 16
            ,shade: 0.3
          });  
    $.ajax({
          'url':'ajax/cancel_for_leave.php',
          'type':'post',
          'dataType':'json',
          'data':data,
          'success':function(ret){
            if(ret.flag){              
              //询问框
              layer.alert('提交成功', {icon: 1}, function(){
                $("#status"+data.id).text("已销假");
                layer.close(layer.index);
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