<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>管理首页_老龟的沙滩</title>
        <link rel="stylesheet" href="/public/css/manage/style.css" type="text/css" />
        <link rel="stylesheet" href="/public/css/manage/custom.css" type="text/css" />
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
                <h1>管理首页</h1>
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
                        <div class="column width3 first">
                            <h3>欢迎回来，<?php echo anchor(current_url() . '###', $this->session->userdata('UserName')); ?></h3>
                            <p>
                                您的用户 ID 为 <?php echo $this->session->userdata('UserID'); ?><br/>
                                您的电子邮箱为 <?php echo $this->input->cookie('UserEmail'); ?><br/>
                                数据库大小 <?php echo $mysql->data_size;?> 文章占用 <?php echo $post->data_size;?>
                            </p>
                        </div>
                        <div class="column width3">
                            <h4>本次登录信息</h4>
                            <p>
                                总登录次数为 <?php echo $LogTimes['LogTimes']; ?><br/>
                                登录地址为 <?php echo $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT']; ?><br/>
                                客户端信息 <?php echo $_SERVER['HTTP_USER_AGENT']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="colgroup leading">
                        <div class="column width3 first">
                            <h4>内容总计</h4>
                            <hr/>
                            <table class="no-style full">
                                <tbody>
                                    <tr>
                                        <td>文章</td>
                                        <td class="ta-right"><?php echo anchor('manage/post', $blogall); ?> 篇</td>
                                    </tr>
                                    <tr>
                                        <td>其他</td>
                                        <td class="ta-right"><?php echo anchor('manage/other', $otherall); ?> 项</td>
                                    </tr>
                                    <tr>
                                        <td>评论</td>
                                        <td class="ta-right"><?php echo anchor('manage/comment', $commentall); ?> 条</td>
                                    </tr>
                                    <tr>
                                        <td>留言</td>
                                        <td class="ta-right"><?php echo anchor('manage/guest', $guestall); ?> 条</td>
                                    </tr>
                                    <tr>
                                        <td>链接</td>
                                        <td class="ta-right"><?php echo anchor('manage/link', $linkall); ?> 个</td>
                                    </tr>
                                    <tr>
                                        <td>用户</td>
                                        <td class="ta-right"><?php echo anchor('manage/user', $userall); ?> 位</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="column width3">
                            <h4>待审/草稿信息</h4>
                            <hr/>
                            <table class="no-style full">
                                <tbody>
                                    <tr>
                                        <td>文章</td>
                                        <td class="ta-right"><?php echo anchor('manage/post/to', $blogto); ?> 篇</td>
                                    </tr>
                                    <tr>
                                        <td>其他</td>
                                        <td class="ta-right"><?php echo anchor('manage/other/to', $otherto); ?> 项</td>
                                    </tr>
                                    <tr>
                                        <td>评论</td>
                                        <td class="ta-right"><?php echo anchor('manage/comment/to', $commentto); ?> 条</td>
                                    </tr>
                                    <tr>
                                        <td>留言</td>
                                        <td class="ta-right"><?php echo anchor('manage/guest/to', $guestto); ?> 条</td>
                                    </tr>
                                    <tr>
                                        <td>链接</td>
                                        <td class="ta-right"><?php echo anchor('manage/link/to', $linkto); ?> 个</td>
                                    </tr>
                                    <tr>
                                        <td>用户</td>
                                        <td class="ta-right"><?php echo anchor('manage/user/to', $userto); ?> 位</td>
                                    </tr>
                                </tbody>
                            </table>
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
        </script>
    </body>
</html>