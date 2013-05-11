<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>管理登录_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="/public/css/jquery.buttonCaptcha.styles.css" />
        <script type="text/javascript" SRC="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.tipTip.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.superfish.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.supersubs.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.validate_pack.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.nyroModal.pack.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery-ui-1.8.10.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery.buttonCaptcha.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                /* setup navigation, content boxes, etc... */
                Administry.setup();
                // validate signup form on keyup and submit
                var validator = $("#loginform").validate({
                    rules: {
                        UserName: "required",
                        password: "required"
                    },
                    messages: {
                        UserName: "用户名不能为空",
                        password: "密码不正确"
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
    </head>
    <body>
        <!-- Header -->
        <header id="top">
            <div class="wrapper-login">
                <div id="title"><span>MeMo Blog</span> 管理登录</div>
            </div>
        </header>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper-login"></div>
        </div>
        <!-- End of Page title -->
        <!-- Page content -->
        <div id="page">
            <!-- Wrapper -->
            <div class="wrapper-login">
                <!-- Login form -->
                <section class="full">
                    <?php echo form_open('manage/login/check',array('id' => 'loginform'));?>
                        <p>
                            <label class="required">用户名:</label><br/>
                            <?php echo form_input('UserName','','id = "UserName" class="full"');?>
                        </p>
                        <p>
                            <label class="required">密&nbsp;&nbsp;&nbsp;码:</label><br/>
                            <?php echo form_password('Password','','id="Password" class="full"');?>
                        </p>
                        <p>
                            <input type="submit" class="btn btn-green big yourbutton" value="登录"/> &nbsp; <a href="<?php echo current_url();?>" onClick="$('#emailform').slideDown(); return false;">忘记密码</a></a>
                        </p>
                        <div class="clear">&nbsp;</div>
                    <?php echo form_close()?>
                    <form id="emailform" style="display:none" method="post" action="main/repass/email">
                        <div class="box">
                            <p id="emailinput">
                                <label>注册时使用的电子邮箱:</label><br/>
                                <input type="text" id="email" class="full" value="" name="UserEmail"/>
                            </p>
                            <p>
                                <input type="submit" class="btn" value="发送"/>
                            </p>
                        </div>
                    </form>
                </section>
                <!-- End of login form -->
            </div>
            <!-- End of Wrapper -->
        </div>
        <!-- End of Page content -->
        <!-- Page footer -->
        <?php include 'footer.php'; ?>
        <!-- End of Page footer -->
        <!-- User interface javascript load -->
        <script type="text/javascript" SRC="../../public/scripts/administry.js"></script>
        <script type="text/javascript">
            $(function(){
                $(".yourbutton").buttonCaptcha({
                    codeWord:'just',
                    codeZone:'free'
                });
                Administry.setup();
            });
        </script>
    </body>
</html>