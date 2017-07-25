<?php 

require_once("inc/global.php");

$key = intval($_GET['key']);

if(!$key){
	header('Location:'.GURL_ROOT.'login.php');
			exit;
}
$conn = icharm_db::factory('ask');

$sql = "SELECT p1.* , p2.name AS class_name FROM `ask_class` p2 JOIN (SELECT t1.* ,t2.name AS student_name FROM `ask_leave_queue` t1 JOIN `ask_student` t2 ON t1.student_id = t2.id WHERE t1.mentor_id = :mentor_id) p1 ON p1.class_id = p2.id";
$leave = $conn->fetchRows($sql, array(':mentor_id'=>$key));
$mentor = getMentorInfo($key);
//var_dump($leave);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>辅导员端-南邮请销假系统</title>
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
    <script src="assets/js/echarts.min.js"></script>
</head>

<body data-type="index">


    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href="javascript:;" class="tpl-logo">
                <img src="assets/img/logo.png" alt="">
                
            </a>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">

        </div>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                
                
                <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen" class="tpl-header-list-link"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>

                <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                    <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                        <span class="tpl-header-list-user-nick"><?php echo $mentor['name'] ?></span>
                    </a>

                </li>
            </ul>
        </div>
    </header>

    <div class="tpl-content-wrapper tpl-content-wrapper-hover">
            <div class="tpl-content-page-title">
                
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home"></a></li>
                <li><a href="#"></a></li>
                <li class="am-active"></li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 审核请假请求
                    </div>
                    <div class="tpl-portlet-input tpl-fz-ml">
                        <div class="portlet-input input-small input-inline">
                            <!-- div class="input-icon right">
                                <i class="am-icon-search"></i>
                                <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div> -->
                        </div>
                    </div>


                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <!-- <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-archive"></span> 审核</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-form-group">
                                <select data-am-selected="{btnSize: 'sm'}">
					              <option value="option1">所有类别</option>
					              <option value="option2">IT业界</option>
					              <option value="option3">数码产品</option>
					              <option value="option3">笔记本电脑</option>
					              <option value="option3">平板电脑</option>
					              <option value="option3">只能手机</option>
					              <option value="option3">超极本</option>
					            </select>
                            </div>
                        </div> -->
                        <!-- <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-input-group am-input-group-sm">
                                <input type="text" class="am-form-field">
                                <span class="am-input-group-btn">
					            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
					          </span>
                            </div>
                        </div> -->
                    </div>
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <form class="am-form">
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-check"><input type="checkbox" class="tpl-table-fz-check"></th>
                                            <th class="table-id">ID</th>
                                            <th class="table-title">请假人</th>
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
                                    	<?php foreach($leave as $k => $v){ 

                                    		?>
                                        <tr id="<?php echo $v['id']; ?>">
                                            <td><input type="checkbox"></td>
                                            <td><?php echo $k; ?></td>
                                            <td><?php echo $v['student_name']; ?></td>
                                            <td><?php echo $v['class_name']; ?></td>
                                            <td><?php echo $v['start']; ?></td>
                                            <td><?php echo $v['end']; ?></td>
                                            <td><?php echo $v['reason']; ?></td>
                                            <td id="status<?php echo $v['id']; ?>" ><?php echo whichStatus($v['status']); ?></td>
                                            <td class="am-hide-sm-only"><?php echo $v['date']; ?></td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                    	<a onclick="ask_pass(<?php echo $v['id'] ?>)" class="am-btn am-btn-default am-btn-xs am-text-secondary"> 通过</a>
                                                        <a onclick="ask_reject(<?php echo $v['id'] ?>)" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"> 拒绝</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </form>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <div class="am-modal am-modal-loading am-modal-no-btn" tabindex="-1" id="delete-loading">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">加载中...</div>
		    <div class="am-modal-bd">
		      <span class="am-icon-spinner am-icon-spin"></span>
		    </div>
		  </div>
		</div>

<?php require("footer.php"); ?>
<script type="text/javascript">

	function ask_pass(id){
		var data = {};
		data.ac = 1;
		data.id = id;
		if($("#status"+data.id).text() != "待审核"){
			layer.alert("该条数据状态不可更改！", {icon: 2});
			return false;
		}
		layer.confirm('确定通过？', {
                btn: ['通过','取消'] //按钮
              }, function(){
              	layer.msg('加载中', {
					  icon: 16
					  ,shade: 0.3
					});
                $.ajax({
                  'url':'ajax/mentor.php',
                  'type':'post',
                  'dataType':'json',
                  'data': data,
                  'success':function(ret){
                  	
                    if(ret.flag){
                    	layer.alert("提交成功", {icon: 1}, function(){
                    		$("#status"+data.id).text("审核通过");
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
              }, function(){

              });
	}

	function ask_reject(id){
		var data = {};
		data.ac = 2;
		data.id = id;
		if($("#status"+data.id).text() != "待审核"){
			layer.alert("该条数据状态不可更改！", {icon: 2});
			return false;
		}
		layer.confirm('确定拒绝？', {
                btn: ['拒绝','取消'] //按钮
              }, function(){
              	layer.msg('加载中', {
					  icon: 16
					  ,shade: 0.3
					});
                $.ajax({
                  'url':'ajax/mentor.php',
                  'type':'post',
                  'dataType':'json',
                  'data': data,
                  'success':function(ret){
                  	
                    if(ret.flag){
                    	layer.alert("提交成功", {icon: 1}, function(){
                    		$("#status"+data.id).text("已拒绝");
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
              }, function(){

              });
	}

	

</script>

</body>

</html>

