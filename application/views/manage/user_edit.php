<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>编辑用户_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <script type="text/javascript" SRC="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.tipTip.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.superfish.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.supersubs.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.validate_pack.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.nyroModal.pack.js"></script>
    </head>
    <body>
        <!-- Header -->
        <?php include 'header.php'; ?>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper">
                <h1>编辑用户</h1>
            </div>
        </div>
        <!-- End of Page title -->
        <!-- Page content -->
        <div id="page">
            <!-- Wrapper -->
            <div class="wrapper">
                <!-- Left column/section -->
                <section class="column width6 first">
                    <?php echo form_open((($id = $this->uri->segment(4)) === FALSE) ? 'manage/user/insert' : 'manage/user/update', array('id' => 'postform')); ?>
                    <fieldset>
                        <?php echo form_hidden('UserID', ($id === FALSE) ? '' : $this->uri->segment(4)); ?>
                        <div class="clearfix leading">
                            <div class="column width3 first">
                                <?php echo form_hidden('UserID', ($id === FALSE) ? '' : $this->uri->segment(4)); ?>
                                <p>
                                    <label class="required">用户名称：</label><br/>
                                    <?php echo form_input('UserName', ($id === FALSE) ? '' : $post['UserName'], 'id="UserName", class="full"'); ?>
                                </p>

                                <p>
                                    <label class="required">用户密码：</label><br/>
                                    <?php echo form_password(array('class' => 'full', 'id' => 'Password', 'name' => 'Password')); ?>
                                </p>
                                <p>
                                    <label class="required">再次输入用户密码：</label><br/>
                                    <?php echo form_password(array('class' => 'full', 'id' => 'RePass', 'name' => 'RePass')); ?>
                                </p>
                            </div>
                            <div class="column width3">
                                <p>
                                    <label class="required">电子邮箱：</label><br/>
                                    <?php echo form_input('UserEmail', ($id === FALSE) ? '' : $post['UserEmail'], 'id="UserEmail", class="full"'); ?>
                                </p>
                                <p>
                                    <label class="required">网站网址：</label><br/>
                                    <?php echo form_input('WebSite', ($id === FALSE) ? '' : $post['WebSite'], 'id="WebSite", class="full"'); ?>
                                </p>
                                <p>
                                    <label>是否启用：</label><br/>
                                    <?php echo form_checkbox('IsShowID', '1', TRUE); ?>
                                </p>
                            </div>
                        </div>
                        <p class="box">
                            <input type="submit" class="btn btn-green big" value="提交"/>
                            &nbsp;&nbsp;
                            <input type="reset" class="btn" value="取消"/>
                        </p>
                    </fieldset>
                    <?php echo form_close(); ?>
                </section>
                <!-- End of Left column/section -->
                <!-- Right column/section -->
                <?php include 'sidebar.php'; ?>
                <!-- End of Right column/section -->
            </div>
            <!-- End of Wrapper -->
        </div>
        <!-- End of Page content -->
        <!-- Page footer -->
        <?php include 'footer.php'; ?>
        <!-- End of Page footer -->
        <!-- Admin template javascript load -->
        <script type="text/javascript" SRC="/public/scripts/administry.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                /* setup navigation, content boxes, etc... */
                Administry.setup();
                // validate signup form on keyup and submit
                var validator = $("#postform").validate({
                    rules: {
                        Website:"required",
                        UserName:"required",
                        UserEmail:{
                            required: true,
                            email: true
                        },
                        Password:{
                            minlength: 6
                        },
                        RePass:{
                            minlength: 6,
                            equalTo: "#Password"
                        }
                    },
                    messages: {
                        Website:"网址不能为空",
                        UserName:"站长名不能为空",
                        UserEmail:{
                            required: "电子邮箱不能为空",
                            email: "格式错误"
                        },
                        Password:{
                            minlength: jQuery.format("密码字符数至少为 {0}")
                        },
                        RePass:{
                            minlength: jQuery.format("密码字符数至少为 {0}"),
                            equalTo: "两次输入的新密码不同"
                        }
                    },
                    // the errorPlacement has to take the layout into account
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent().find('label:first'));
                    },
                    // set new class to error-labels to indicate valid fields
                    success: function(label) {
                        // set &nbsp; as text for IE
                        label.html("&nbsp;").addClass("ok");
                    }
                });
            });
        </script>
    </body>
</html>