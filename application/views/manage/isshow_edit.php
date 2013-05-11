<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>编辑状态_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <script type="text/javascript" SRC="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.tipTip.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.superfish.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.supersubs.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.nyroModal.pack.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.validate_pack.js"></script>
    </head>
    <body>
        <!-- Header -->
        <?php include 'header.php'; ?>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper">
                <h1>编辑状态</h1>
            </div>
        </div>
        <!-- End of Page title -->
        <!-- Page content -->
        <div id="page">
            <!-- Wrapper -->
            <div class="wrapper">
                <!-- Left column/section -->
                <section class="column width6 first">
                    <?php echo form_open((($id = $this->uri->segment(4)) === FALSE) ? 'manage/isshow/insert' : 'manage/isshow/update', array('id' => 'postform')); ?>
                    <fieldset>
                        <?php echo form_hidden('IsShowID', ($id === FALSE) ? '' : $id); ?>
                        <p>
                            <label class="required">状态名称：</label><br/>
                            <?php echo form_input('IsShowName', ($id === FALSE) ? '' : $post['IsShowName'], 'class="half" id="IsShowName"'); ?>
                        </p>
                        <p>
                            <label>状态排序：</label><br/>
                            <?php echo form_input('IsShowOrder', ($id === FALSE) ? '' : $post['IsShowOrder'], 'class="half" id="IsShowOrder"'); ?>
                        </p>
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
                        IsShowName: "required"
                    },
                    messages: {
                        IsShowName: "状态名不能为空"
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
