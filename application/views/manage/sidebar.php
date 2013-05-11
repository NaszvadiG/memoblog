<aside class="column width2">
    <div id="rightmenu">
        <header>
            <h3>快捷通道</h3>
        </header>
        <dl class="first">
            <dt><img width="16" height="16" alt="" SRC="/public/images/manage/key.png"></dt>
            <dd><?php echo anchor('manage/main/password', '更改密码'); ?></dd>
            <dd class="last">当前登录名为：<?php echo $this->session->userdata('UserName'); ?> ID：<?php echo $this->session->userdata('UserID'); ?></dd>
            <dt><img width="16" height="16" alt="" SRC="/public/images/manage/help.png"></dt>
            <dd><?php echo anchor('manage/main/setting', '系统设置'); ?> &nbsp; <?php echo anchor('manage/main/backup', '备份数据'); ?></dd>
            <dd><?php echo anchor('manage/main/clear', '清空缓存'); ?></dd>
            <dd><?php echo anchor('manage/post/edit', '发表文章'); ?> &nbsp; <?php echo anchor('manage/post/to', '草稿文章'); ?></dd>
            <dd><?php echo anchor('manage/guest/to', '待审留言'); ?> &nbsp; <?php echo anchor('manage/comment/to', '待审评论'); ?></dd>
            <dd><?php echo anchor('manage/other/to', '待审其他'); ?></dd>
        </dl>
    </div>
    <div class="content-box">
        <header>
            <h3>系统状态</h3>
        </header>
        <section>
            <dl>
                <dt>主机名：<?php echo $_SERVER['SERVER_NAME']; ?></dt>
                <dd>端口/协议：<?php echo $_SERVER['SERVER_PORT'] . '/' . $_SERVER['GATEWAY_INTERFACE']; ?></dt>
                <dd>系统目录：<?php echo $_SERVER['DOCUMENT_ROOT']; ?></dd>
                <dt><?php echo ($_SERVER['HTTP_REFERER']) ? anchor($_SERVER['HTTP_REFERER'], '返回上一页') : ''; ?> &nbsp; <?php echo anchor('', '返回系统首页'); ?></dt>
                <dd>远程登录信息：<?php echo $_SERVER['REMOTE_ADDR'] . ':' . $_SERVER['REMOTE_PORT']; ?></dd>
            </dl>
        </section>
    </div>
</aside>