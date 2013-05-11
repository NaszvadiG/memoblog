<header id="top">
    <div class="wrapper">
        <!-- Title/Logo - can use text instead of image -->
        <div id="title"><span>MeMo Blog</span> 管理平台</div>
        <!-- Main navigation -->
        <nav id="menu">
            <ul class="sf-menu" id="sf-menu">
                <li class="current">
                    <?php echo anchor('manage/main', '管理首页'); ?>
                    <ul>
                        <li><?php echo anchor('manage/main/setting', '系统设置'); ?></li>
                        <li>
                            <?php echo anchor('manage/isshow', '状态管理'); ?>
                            <ul>
                                <li><?php echo anchor('manage/isshow', '状态列表'); ?></li>
                                <li><?php echo anchor('manage/isshow/edit', '新增状态'); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <?php echo anchor('manage/post', '文章管理'); ?>
                    <ul>
                        <li><?php echo anchor('manage/post/edit', '发布文章'); ?></li>
                        <li><?php echo anchor('manage/post', '文章列表'); ?></li>
                        <li><?php echo anchor('manage/post/to', '草稿列表'); ?></li>
                        <li>
                            <?php echo anchor('manage/sort', '分类管理'); ?>
                            <ul>
                                <li><?php echo anchor('manage/sort', '分类列表'); ?></li>
                                <li><?php echo anchor('manage/sort/to', '待审分类'); ?></li>
                                <li><?php echo anchor('manage/sort/edit', '新增分类'); ?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('manage/tag', '标签列表'); ?></li>
                    </ul>
                </li>
                <li>
                    <?php echo anchor('manage/guest', '留言管理'); ?>
                    <ul>
                        <li><?php echo anchor('manage/guest', '留言列表'); ?></li>
                        <li><?php echo anchor('manage/guest/to', '待审留言'); ?></li>
                        <li>
                            <?php echo anchor('manage/comment', '评论管理'); ?>
                            <ul>
                                <li><?php echo anchor('manage/comment', '评论列表'); ?></li>
                                <li><?php echo anchor('manage/comment/to', '待审评论'); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <?php echo anchor('manage/link', '链接管理'); ?>
                    <ul>
                        <li><?php echo anchor('manage/link/edit', '新增链接'); ?></li>
                        <li><?php echo anchor('manage/link', '链接列表'); ?></li>
                        <li><?php echo anchor('manage/link/to', '待审链接'); ?></li>
                    </ul>
                </li>
                <li>
                    <?php echo anchor('manage/other', '其他管理'); ?>
                    <ul>
                        <li><?php echo anchor('manage/other/edit', '新增其他'); ?></li>
                        <li><?php echo anchor('manage/other', '其他列表'); ?></li>
                        <li><?php echo anchor('manage/other/to', '待审其他'); ?></li>
                    </ul>
                </li>
                <li>
                    <?php echo anchor('manage/user', '用户管理'); ?>
                    <ul>
                        <li><?php echo anchor('manage/user/edit', '新增用户'); ?></li>
                        <li><?php echo anchor('manage/user', '用户列表'); ?></li>
                        <li><?php echo anchor('manage/user/to', '待审用户'); ?></li>
                        <li><?php echo anchor('manage/main/password', '更改密码'); ?></li>
                    </ul>
                </li>
                <li><?php echo anchor('manage/login/logout', '退出登录'); ?></li>
            </ul>
        </nav>
        <script type="text/javascript" language="javascript">
            var nav = document.getElementById("sf-menu");
            var links = nav.getElementsByTagName("li");
            var lilen = nav.getElementsByTagName("a");
            var currenturl = document.location.href;
            var last = 0;
            for (var i = 0; i < links.length; i++) {
                var linkurl = lilen[i].getAttribute("href");
                if (currenturl.indexOf(linkurl) != -1) {
                    last = i;
                }
            }
            links[last].className = "current";
        </script>
        <!-- End of Main navigation -->
    </div>
</header>