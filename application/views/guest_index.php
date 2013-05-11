<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>留言_老龟的沙滩</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="老龟的沙滩" />
        <link rel="stylesheet" type="text/css" href="/public/css/style.css" media="screen" />
        <script type="text/javascript" src="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/public/scripts/superfish.js"></script>
        <script type="text/javascript" src="/public/scripts/script.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery-ui-1.8.10.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery.buttonCaptcha.min.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/vanadium.js"></script>
        <link rel="stylesheet" type="text/css" href="/public/css/jquery.buttonCaptcha.styles.css" />
    </head>
    <body>
        <div id="page">
            <?php include 'include/header.php'; ?>
            <!--/header -->
            <div id="columns">
                <div id="centercol">
                    <div class="box post" id="post-41">
                        <?php
                        if ($guest->num_rows === 0) {
                            echo '尚未有公开发表的留言';
                        } else {
                            ?>
                            <?php foreach ($guest->result() as $item): ?>
                                <div class="comment">
                                    <a name="<?php echo $item->GuestID; ?>"></a>
                                    <strong><?php echo $item->UserName; ?> @ <?php echo $item->AddTime; ?></strong>
                                    <br/>
                                    <?php echo $item->GuestBody; ?>
                                    <?php if ($item->ReplyBody != "") { ?>
                                        <p class="reply">
                                            <strong>回复于 <?php echo $item->ReplyTime; ?></strong>
                                            <br/>
                                            <?php echo $item->ReplyBody; ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="clr"></div>
                        <?php echo $this->pagination->create_links(); ?>
                    <?php } ?>
                    <div class="clr"></div>
                    <div class="post-title">
                        <h3>留下爪印<a name="insert"></a><span id="notice" style="display:none;"></span></h3>
                    </div>
                    <div class="post-comment">
                        <p>
                            <label>尊姓大名&nbsp;<?php echo form_error('UserName'); ?></label>
                            <?php echo form_input('UserName', (set_value('UserName') === '') ? get_cookie('UserName', TRUE) : set_value('UserName'), 'class=":required" id="UserName"'); ?>
                            <label>电子邮箱(不会被公开)&nbsp;<?php echo form_error('UserEmail'); ?></label>
                            <?php echo form_input('UserEmail', (set_value('UserEmail') === '') ? get_cookie('UserEmail', TRUE) : set_value('UserName'), 'class=":email" id="UserEmail"'); ?>
                            <label>评论内容&nbsp;<?php echo form_error('GuestBody'); ?></label>
                            <?php echo form_textarea(array('value' => set_value('GuestBody'), 'name' => 'GuestBody', 'id' => 'GuestBody', 'class' => ':required')); ?>
                            <div class="clr"></div>
                            <input class="yourbutton" type="submit" id="submit" value="提交" />
                        </p>
                    </div>
                    <!--/box -->
                </div>
                <!--/centercol -->
                <div id="rightcol">
                    <?php include 'include/sidebar.php'; ?>
                </div>
                <!--/rightcol -->
                <div class="clr"></div>
            </div>
            <!--/columns -->
            <div class="clr"></div>
        </div>
        <!--/page -->
        <?php include 'include/footer.php'; ?>
        <script type="text/javascript">
            $(function(){
                $(".yourbutton").buttonCaptcha({
                    codeWord:'just',
                    codeZone:'free'
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#submit').click(function(){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('guest/ajaxinsert'); ?>",
                        data: "UserName=" + $('#UserName').val() + "&UserEmail=" + $('#UserEmail').val() + "&GuestBody=" + $('#GuestBody').val(),
                        success: function(data){
                            $('#notice').html(data).slideToggle().delay(1000).slideToggle('slow');
                        }
                    });
                    return false;
                });
            });
        </script>
        <script type="text/javascript">
            $(function(){
                //必填项加红 *
                $("input[class*=:required]").after("<span> *</span>")
            });
            //弹出信息样式设置
            Vanadium.config = {
                valid_class: 'rightformcss',//验证正确时表单样式
                invalid_class: 'failformcss',//验证失败时该表单样式
                message_value_class: 'msgvaluecss',//这个样式是弹出信息中调用值的样式
                advice_class: 'failmsg',//验证失败时文字信息的样式
                prefix: ':',
                separator: ';',
                reset_defer_timeout: 100
            }
            //验证类型及弹出信息设置
            Vanadium.Type = function(className, validationFunction, error_message, message, init) {
                this.initialize(className, validationFunction, error_message, message, init);
            };
            Vanadium.Type.prototype = {
                initialize: function(className, validationFunction, error_message, message, init) {
                    this.className = className;
                    this.message = message;
                    this.error_message = error_message;
                    this.validationFunction = validationFunction;
                    this.init = init;
                },
                test: function(value) {
                    return this.validationFunction.call(this, value);
                },
                validMessage: function() {
                    return this.message;
                },
                invalidMessage: function() {
                    return this.error_message;
                },
                toString: function() {
                    return "className:" + this.className + " message:" + this.message + " error_message:" + this.error_message
                },
                init: function(parameter) {
                    if (this.init) {
                        this.init(parameter);
                    }
                }
            };
            Vanadium.setupValidatorTypes = function() {
                Vanadium.addValidatorType('empty', function(v) {
                    return  ((v == null) || (v.length == 0));
                });
                //***************************************以下为验证方法,使用时可仅保留用到的判断
                Vanadium.addValidatorTypes([
                    //是否为空
                    ['required', function(v) {
                            return !Vanadium.validators_types['empty'].test(v);
                        }, '必填项'],
                    //邮箱验证
                    ['email', function (v) {
                            return (Vanadium.validators_types['empty'].test(v) || /\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(v))
                        }, '邮箱格式不正确'],
                ])
                if (typeof(VanadiumCustomValidationTypes) !== "undefined" && VanadiumCustomValidationTypes) Vanadium.addValidatorTypes(VanadiumCustomValidationTypes);
            };
        </script>
    </body>
</html>
