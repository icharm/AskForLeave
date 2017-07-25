<?php

require_once("inc/global.php");

//检查登录
$g_userObj->checkLogin();
//检查权限
if($g_user['power'] != 1){
	header('Location:'.GURL_ROOT.'login.php?backurl='.urlencode($_SERVER['REQUEST_URI']));
			exit;
}

$page = array(
	'title' => '辅导员列表-南邮请销假系统',
    'title_parent' => '辅导员管理',
    'form_title' => '辅导员列表',
	);

$conn = icharm_db::factory("ask");
$sql = "SELECT * FROM `ask_mentor`";
$teacher = $conn->fetchRows($sql);

require_once("header.php");
?>


<div class="tpl-content-wrapper">
            <div class="tpl-content-page-title">
                <?php echo $page['form_title']; ?>
            </div>
            <ol class="am-breadcrumb">
                <li><a href="index.php" class="am-icon-home">首页</a></li>
                <li><a href="#"><?php echo $page['title_parent']; ?></a></li>
                <li class="am-active"><?php echo $page['form_title']; ?></li>
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> <?php echo $page['form_title']; ?>
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
                                            <th class="table-title">名字</th>
                                            <th class="table-type">邮箱</th>
                                            <th class="table-type">性别</th>
                                            <!-- <th class="table-author am-hide-sm-only">作者</th> -->
                                            <th class="table-date am-hide-sm-only">修改日期</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach($teacher as $k => $v){ ?>
                                        <tr id="<?php echo $v['id']; ?>">
                                            <td><input type="checkbox"></td>
                                            <td><?php echo $k; ?></td>
                                            <td><?php echo $v['name']; ?></td>
                                            <td><?php echo $v['mail']; ?></td>
                                            <td><?php echo $v['gender']==1?'男':'女'; ?></td>
                                            <td class="am-hide-sm-only"><?php echo $v['date']; ?></td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a onclick="mentor_delete(<?php echo $v['id'] ?>)" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</a>
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
		    <div class="am-modal-hd">正在删除...</div>
		    <div class="am-modal-bd">
		      <span class="am-icon-spinner am-icon-spin"></span>
		    </div>
		  </div>
		</div>

<?php require("footer.php"); ?>
<script type="text/javascript">
	function mentor_delete(id){
		var data = {};
		data.who = 3;
		data.id = id;
		layer.confirm('确定删除？', {
                btn: ['删除','取消'] //按钮
              }, function(){
              	//layer.closeAll();
              	//console.log(id);
                $('#delete-loading').modal('open');
                //console.log(id);
                $.ajax({
                  'url':'ajax/delete.php',
                  'type':'post',
                  'dataType':'json',
                  'data': data,
                  'success':function(ret){
                  	$('#delete-loading').modal('close');
                    if(ret.flag){
                    	layer.alert("删除成功", {icon: 1}, function(){
                            //动态删除列表项
                            $("#"+data.id).remove();
                            layer.close(layer.index);
                        });

                    }else{
                      layer.alert(ret.msg, {icon: 2});
                      return false;
                    }
                  },
                  'error':function(ret){
                  	$('#delete-loading').modal('close');
                    layer.alert("网络错误,请稍后再试！", {icon: 2});
                    return false;
                  },
                })
              }, function(){
                //layer.closeAll();
              });
		
	}

</script>

</body>

</html>
