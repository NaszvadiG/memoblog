<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>标签_老龟的沙滩</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="description" content="老龟的沙滩" />
        <link rel="stylesheet" type="text/css" href="/public/css/style.css" media="screen" />
        <script type="text/javascript" src="/public/scripts/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/public/scripts/superfish.js"></script>
        <script type="text/javascript" src="/public/scripts/script.js"></script>
    </head>
    <body>
        <div id="page">
            <?php include 'include/header.php'; ?>
            <!--/header -->
            <div id="columns">
                <div id="centercol">
                    <!--判断是否存在文章-->
                    <?php
                    if ($list->num_rows == 0) {
                        echo '尚未有设定的标签';
                    } else {
                        ?>
                        <div class="box post" id="post-41">
                            <!--显示当前分类下所有文章-->
                            <?php foreach ($list->result() as $item): ?>
                                <?php echo anchor('blog/tag/' . $item->TagID, $item->TagName); ?>(<?php echo $item->ReadNum; ?>)&nbsp;
                            <?php endforeach; ?>
                        </div>
                        <!--/box -->
                    <?php } ?>
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
    </body>
</html>