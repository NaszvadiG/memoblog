<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>文章列表_老龟的沙滩</title>
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
                <h1>文章列表</h1>
                <!-- Quick search box -->
                <form action="post/search" method="get"><input class="" type="text" id="id" name="id" /></form>
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
                    <?php echo form_open('manage/post/delete');?>
                    <table class="stylized full">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="fx" /></th>
                                <th>编号</th>
                                <th>文章名称</th>
                                <th width="55px">文章分类</th>
                                <th width="30px">评阅</th>
                                <th width="65px">发布时间</th>
                                <th width="55px">状态</th>
                                <th width="60px">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($list->num_rows === 0) {
                                echo '<tr><td colspan="8">暂无文章</td></tr>';
                            } else {
                                foreach ($list->result() as $item):
                                    ?>
                                    <tr>
                                        <td class="a-center"><input type="checkbox" name="PostID[]" id="fxs" value="<?php echo $item->PostID; ?>" class="xx"/></td>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $item->PostTitle; ?></td>
                                        <td><?php echo anchor('manage/post/sort/' . $item->SortID, $item->SortName); ?></td>
                                        <td><?php echo anchor('manage/comment/post/' . $item->PostID, $item->ReadNum . '/' . $item->Comment); ?></td>
                                        <td><?php echo $item->AddTime; ?></td>
                                        <td><?php echo $item->IsShowName; ?></td>
                                        <td><a href="/index.php/blog/post/<?php echo $item->PostID; ?>" target="_blank"><img src="/public/images/icons/user.png" title="查看" width="16" height="16" /></a><a href="/index.php/manage/post/edit/<?php echo $item->PostID; ?>"><img src="/public/images/icons/user_edit.png" title="编辑" width="16" height="16" /></a><a href="/index.php/manage/post/delete/<?php echo $item->PostID; ?>" onclick="return confirmAct();"><img src="/public/images/icons/user_delete.png" title="删除" width="16" height="16" /></a></td>
                                    </tr>
                                    <?php
                                endforeach;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><input type="submit" class="btn" onclick="return confirmAct();" value="删除"/></td>
                                <td>每页 <b><?php echo $page['num']; ?></b> 条 / 当前 <b><?php echo $page['c_num'] + 1; ?> ~ <?php echo $page['c_num'] + $list->num_rows; ?></b> 条 / <b><?php echo $page['page']; ?></b> 页 / <b><?php echo $page['total']; ?></b> 条</td>
                                <td colspan="5"><?php echo $this->pagination->create_links(); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php echo form_close();?>
                    <div class="clearfix"></div>
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
            $("#fx").click(selectAll);//全选，反选
            function selectAll() {
                var checked = $(".stylized").attr("checked");
                $(".xx").each(function() {
                    var subchecked = $(this).attr("checked");
                    if (subchecked != checked)
                        $(this).click();
                });
            }
            $(".stylized tr").mouseover(function(){
                $(this).addClass("high");}).mouseout(function(){
                $(this).removeClass("high");});
            function confirmAct()
            {
                if(confirm("确定要删除吗?"))
                {
                    return true;
                }
                return false;
            }
        </script>
    </body>
</html>