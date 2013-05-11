<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>标签列表_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <script type="text/javascript" SRC="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.superfish.min.js"></script>
        <script type="text/javascript" SRC="/public/scripts/jquery.supersubs.min.js"></script>
    </head>
    <body>
        <!-- Header -->
        <?php include 'header.php'; ?>
        <!-- End of Header -->
        <!-- Page title -->
        <div id="pagetitle">
            <div class="wrapper">
                <h1>标签列表</h1>
            </div>
        </div>
        <!-- End of Page title -->
        <!-- Page content -->
        <div id="page">
            <!-- Wrapper -->
            <div class="wrapper">
                <!-- Left column/section -->
                <section class="column width6 first">
                    <div class="colgroup leading">
                        <div class="width3 column first">
                            <p>每页 <b><?php echo $page['num']; ?></b> 条 / 当前 <b><?php echo $count = $page['c_num'] + 1; ?> ~ <?php echo $page['c_num'] + $list->num_rows; ?></b> 条 / 计 <b><?php echo $page['page']; ?></b> 页 / 共 <b><?php echo $page['total']; ?></b> 条</p>
                        </div>
                        <div class="width3 column">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <table class="stylized full">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>名称</th>
                                <th>关注度</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($list->num_rows === 0) {
                                echo '<tr><td colspan="3">暂无标签</td></tr>';
                            } else {
                                foreach ($list->result() as $item):
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $item->TagName; ?></td>
                                        <td><?php echo $item->ReadNum; ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="colgroup leading">
                        <div class="width3 column first">
                            <p>每页 <b><?php echo $page['num']; ?></b> 条 / 当前 <b><?php echo $page['c_num'] + 1; ?> ~ <?php echo $page['c_num'] + $list->num_rows; ?></b> 条 / 计 <b><?php echo $page['page']; ?></b> 页 / 共 <b><?php echo $page['total']; ?></b> 条</p>
                        </div>
                        <div class="width3 column">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
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
            });
            $(".stylized tr").mouseover(function(){
                $(this).addClass("high");}).mouseout(function(){
                $(this).removeClass("high");})
        </script>
    </body>
</html>