<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ($row != NULL) ? $page_title : '文章未发布'; ?>_老龟的沙滩</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="老龟的沙滩" />
        <link rel="stylesheet" type="text/css" href="/public/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/public/css/jquery.buttonCaptcha.styles.css" />
        <script type="text/javascript" src="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/public/scripts/superfish.js"></script>
        <script type="text/javascript" src="/public/scripts/script.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery-ui-1.8.10.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/jquery.buttonCaptcha.min.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/vanadium.js"></script>
        <script type="text/javascript" language="javascript" src="/public/scripts/scrolltopcontrol.js"></script>
    </head>
    <body>
        <div id="page">
            <?php include 'include/header.php'; ?>
            <!--/header -->
            <div id="columns">
                <div id="centercol">
                    <div class="box post" id="post-41">
                        <?php if ($row != NULL) {
                            if ($pass === TRUE) { ?>
                                <div class="content">
                                    <div class="post-title">
                                        <h2><?php echo $page_title; ?><a name="read"></a></h2>
                                    </div>
                                    <div class="social-links">
                                        <div class="post-date"><?= $row['AddTime']; ?> 发表于 <?php echo anchor('blog/sort/' . $row['SortID'], $row['SortName']); ?> 阅读 <?php echo anchor('###', $row['ReadNum']); ?> 评论 <?php echo anchor('blog/post/' . $this->uri->segment(3) . '#comment', $row['Comment']); ?></div>
                                    </div>
                                    <div class="post-excerpt">
                                        <?php echo $row['PostBody']; ?>
                                    </div>
                                </div>
                                <!--/box -->
                                <div class="clr"></div>
                                <div class="post-title">
                                    <h3>你点我评<a name="comment"></a><span id="notice" style="display:none;"></span></h3>
                                </div>
                                <?php
                                if ($post_comment->num_rows === 0) {
                                    echo '尚未有公开发表的评论';
                                } else {
                                    ?>
                                    <?php foreach ($post_comment->result() as $item): ?>
                                        <div class="comment">
                                            <a name="<?php echo $item->CommentID; ?>"></a>
                                            <strong><?php echo $item->UserName; ?> @ <?php echo $item->AddTime; ?></strong>
                                            <br/>
                                            <?php echo $item->CommentBody; ?>
                                            <?php if ($item->ReplyBody != "") { ?>
                                                <p class="reply">
                                                    <strong>回复于 <?php echo $item->ReplyTime; ?></strong>
                                                    <br/>
                                                    <?php echo $item->ReplyBody; ?>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    <?php endforeach;
                                } ?>
                                <div class="clr"></div>
                                <br/>
                                <div class="post-title">
                                    <h3>留下口水<a name="insert"></a></h3>
                                </div>
                                <div class="post-comment">
                                    <?php echo form_hidden('PostID', $this->uri->segment(3)); ?>
                                    <p>
                                        <label>尊姓大名&nbsp;<?php echo form_error('UserName'); ?></label>
                                        <?php echo form_input('UserName', (set_value('UserName') === '') ? get_cookie('UserName', TRUE) : set_value('UserName'), 'class=":required" id="UserName"'); ?>
                                        <label>电子邮箱(不会被公开)&nbsp;<?php echo form_error('UserEmail'); ?></label>
                                        <?php echo form_input('UserEmail', (set_value('UserEmail') === '') ? get_cookie('UserEmail', TRUE) : set_value('UserName'), 'class=":email" id="UserEmail"'); ?>
                                        <label>评论内容&nbsp;<?php echo form_error('CommentBody'); ?></label>
                                        <?php echo form_textarea(array('value' => set_value('CommentBody'), 'name' => 'CommentBody', 'id' => 'CommentBody', 'class' => ':required')); ?>
                                        <div class="clr"></div>
                                        <input class="yourbutton" type="submit" id="submit" value="提交" />
                                    </p>
                                </div>
                                <?php
                            } else {
                                echo '文章被加密，请输入查看密码：' . form_error('Password');
                                ?>
                                <div class="comment">
                                    <?php echo form_open('blog/post/' . $this->uri->segment(3)); ?>
                                    <?php echo form_input('Password'); ?>
                                    <div class="clr"></div>
                                    <input class="yourbutton" type="submit" value="提交" />
                                    <?php echo form_close(); ?>
                                </div>
                                <?php
                            }
                        } else {
                            echo '文章尚未发布';
                        }
                        ?>
                    </div>
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
                        url: "<?php echo site_url('blog/ajaxcomment'); ?>",
                        data: "UserName=" + $('#UserName').val() + "&UserEmail=" + $('#UserEmail').val() + "&CommentBody=" + $('#CommentBody').val(),
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
