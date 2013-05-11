<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>编辑文章_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <script type="text/javascript" SRC="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.tipTip.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.superfish.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.supersubs.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.validate_pack.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.nyroModal.pack.js"></script>
        <script charset="utf-8" src="/public/scripts/kindeditor/kindeditor-min.js"></script>
    </head>
    <body>
        <!-- Header -->
        <?php include 'header.php'; ?>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper">
                <h1>编辑文章</h1>
                <!-- Quick search box -->
                <form action="" method="get"><input class="" type="text" id="q" name="q" /></form>
            </div>
        </div>
        <!-- End of Page title -->
        <!-- Page content -->
        <div id="page">
            <!-- Wrapper -->
            <div class="wrapper">
                <!-- Left column/section -->
                <section class="column width6 first">
                    <?php echo form_open((($id = $this->uri->segment(4)) === FALSE) ? 'manage/post/insert' : 'manage/post/update', array('id' => 'postform')); ?>
                    <fieldset>
                        <?php echo form_hidden('PostID', ($id === FALSE) ? '' : $id); ?>
                        <p>
                            <label class="required">文章名称：</label><br/>
                            <?php echo form_input('PostTitle', ($id === FALSE) ? '' : $post['PostTitle'], 'class="full title" id="PostTitle"'); ?>
                        </p>
                        <p>
                            <label>文章标签：<em>多个标签使用竖线"|"分隔</em></label><br/>
                            <?php echo form_input('TagName', ($id === FALSE) ? '' : $post['TagName'], 'class="full" id="TagName"'); ?>
                        </p>
                        <div class="clearfix leading">
                            <div class="column width3 first">
                                <p>
                                    <label class="required">文章简介：</label><br/>
                                    <?php echo form_textarea('PostAbout', ($id === FALSE) ? '' : $post['PostAbout'], 'class="medium full" id="PostAbout"'); ?>
                                </p>
                            </div>
                            <div class="column width3">
                                <p>
                                    <label class="required">文章分类：</label><br/>
                                    <select name="SortID" class="full" id="SortID">
                                        <?php foreach ($sort->result() as $item): { ?>
                                                <option value="<?php echo $item->SortID; ?>" <?php echo ($id === FALSE || $item->SortID != $post['SortID'])?'':'selected="true"' ?>><?php echo $item->SortName; ?></option>
                                            <?php }
                                        endforeach; ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="required">发布状态：</label><br/>
                                    <select name="IsShowID" class="full" id="IsShowID">
                                        <?php foreach ($isshow->result() as $item): { ?>
                                                <option value="<?php echo $item->IsShowID; ?>" <?php echo ($id === FALSE || $item->IsShowID != $post['IsShowID'])?'':'selected="true"' ?>><?php echo $item->IsShowName; ?></option>
                                            <?php }
                                        endforeach; ?>
                                    </select>
                                </p>
                                <p>
                                    <label>查看密码：</label><br/>
                                    <?php echo form_input('Password', ($id === FALSE) ? '' : $post['Password'], 'class="half" id="Password"'); ?> <em>留空表示无密码</em>
                                </p>
                            </div>
                        </div>
                        <p>
                            <label class="required">文章内容：</label>您当前输入了 <span id="BodyCount">0</span> 个文字。(字数统计包含HTML代码。)<br/>
                            <?php echo form_textarea('PostBody', ($id === FALSE) ? '' : $post['PostBody'], 'class="large full" id="PostBody"'); ?>
                        </p>
                        <p class="box">
                            <input type="submit" class="btn btn-green big" value="提交"/>
                            &nbsp;(提交快捷键: Ctrl + Enter)&nbsp;
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
                KE.show({
                    id : 'PostBody',
                    imageUploadJson : '../../upload_json.php',//<<相对于kindeditor3.5.5\plugins\image\image.html
                    fileManagerJson : '../../file_manager_json.php',//<<相对于kindeditor3.5.5\plugins\file_manager\file_manager.html
                    allowFileManager : true,
                    /*urlType : 'domain',*/
                    afterCreate : function(id) {
                        KE.$('BodyCount').innerHTML = KE.count(id);
                        KE.event.ctrl(document, 13, function() {
                            KE.util.setData(id);
                            document.forms['postform'].submit();
                        });
                        KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
                            KE.util.setData(id);
                            document.forms['postform'].submit();
                        });
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                /* setup navigation, content boxes, etc... */
                Administry.setup();
                // validate signup form on keyup and submit
                var validator = $("#postform").validate({
                    rules: {
                        PostTitle: "required",
                        PostAbout:"required",
                        SortID:"required",
                        IsShowID:"required",
                        PostBody:"required"
                    },
                    messages: {
                        PostTitle: "文章标题不能为空",
                        PostAbout:"文章简介不能为空",
                        SortID:"文章分类不能为空",
                        IsShowID:"显示状态不能为空",
                        PostBody:"文章内容不能为空"
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