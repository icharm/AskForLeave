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
    'title' => '添加辅导员-南邮请销假系统',
    'title_parent' => '辅导员管理',
    'form_title' => '添加辅导员',
    );


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
                <div class="tpl-block ">

                    <div class="am-g tpl-amazeui-form">


                        <div class="am-u-sm-12 am-u-md-9">
                            <form id="add_mentor_form" class="am-form am-form-horizontal">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">姓名 / Name</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="name" id="user-name" placeholder="姓名 / Name">
                                        <!-- <small>输入你的名字，让我们记住你。</small> -->
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-email" class="am-u-sm-3 am-form-label">电子邮件 / Email</label>
                                    <div class="am-u-sm-9">
                                        <input type="email" name="mail" id="user-email" placeholder="电子邮件 / Email">
                                        <!-- <small>邮箱你懂得...</small> -->
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="gender" class="am-u-sm-3 am-form-label">性别 / Gender</label>
                                    <div class="am-u-sm-9">
                                        
                                          <select data-am-selected="{maxHeight: 100}" id="gender" name="gender">

                                            
                                            <option value="1">男</option>
                                            <option value="2">女</option>
                                            
                                          </select>
                                        
                                    </div>
                                </div>    

                                <!-- <div class="am-form-group">
                                    <label for="user-QQ" class="am-u-sm-3 am-form-label">QQ</label>
                                    <div class="am-u-sm-9">
                                        <input type="number" pattern="[0-9]*" id="user-QQ" placeholder="输入你的QQ号码">
                                    </div>
                                </div> -->

                                <!-- <div class="am-form-group">
                                    <label for="user-weibo" class="am-u-sm-3 am-form-label">微博 / Twitter</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" id="user-weibo" placeholder="输入你的微博 / Twitter">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-intro" class="am-u-sm-3 am-form-label">简介 / Intro</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="5" id="user-intro" placeholder="输入个人简介"></textarea>
                                        <small>250字以内写出你的一生...</small>
                                    </div>
                                </div> -->

                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <a onclick="add_mentor_submit()" class="am-btn am-btn-primary">保存修改</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>


<?php require("footer.php"); ?>
<script type="text/javascript">
    function add_mentor_submit(){
    data = {};
        data = $('#add_mentor_form').serialize();
        console.log(data);
        $.ajax({
          'url':'ajax/add_mentor.php',
          'type':'post',
          'dataType':'json',
          'data':data,
          'success':function(ret){
            if(ret.flag){
              
              //询问框
              layer.confirm('辅导员添加成功', {
                btn: ['继续添加','取消'] //按钮
              }, function(){
                layer.closeAll();
              }, function(){
                window.location.href="list-mentor.php";
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
        return true;
      } 

</script>
</body>

</html>