<div class="box">
    <div class="content">
        <ul class="list">
            <li><a href="###" class="active" rel="tabs_sort">分类</a></li>
            <li><a href="###" rel="tabs_archive">归档</a></li>
            <li><a href="###" rel="tabs_tag">标签</a></li>
            <li><a href="###" rel="tabs_link" class="last">链接</a></li>
        </ul>
        <div class="tabs_sort tabs_list">
            <ul class="sf-menu sf-js-enabled" >
                <li class="cat-item">
                    <?php
                    $id = 1;
                    foreach ($sort->result() as $item):
                        $val = anchor('blog/sort/' . $item->SortID, $item->SortName);
                        if ($id > ($_id = count(explode('|', $item->SortLevel)))) {
                            echo str_repeat('</ul></li>', ($id - $_id)) . '<li class="cat-item">' . $val;
                        } else if ($id < count(explode('|', $item->SortLevel))) {
                            echo '<ul  class="children"><li class="cat-item">' . $val;
                        } else if ($id === count(explode('|', $item->SortLevel))) {
                            echo '</li><li class="cat-item">' . $val;
                        }
                        $id = count(explode('|', $item->SortLevel));
                        ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        </div>
        <div class="tabs_archive tabs_list">
            <ul>
                <?php foreach ($archive->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor('blog/archive/' . $item->Mon, $item->Mon . '(' . $item->Num . ')'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tabs_tag tabs_list">
            <div id="memo_tags">
                <?php echo anchor('blog/tag', '查看更多'); ?>
                <?php foreach ($tag->result() as $item): ?>
                    <?php echo anchor('blog/tag/' . $item->TagID, $item->TagName . '(' . $item->ReadNum . ')'); ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tabs_link tabs_list">
            <ul class="sf-menu sf-js-enabled" >
                <?php foreach ($link->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor($item->LinkUrl, $item->LinkName, 'target="_blank"'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!--/content -->
    <br/>
    <div class="content">
        <ul class="list">
            <li><a href="###" class="active" rel="tabs_hot">最热</a></li>
            <li><a href="###" rel="tabs_last">最新</a></li>
            <li><a href="###" rel="tabs_comment">评论</a></li>
            <li><a href="###" rel="tabs_guest" class="last">留言</a></li>
        </ul>
        <div class="tabs_hot tabs_list">
            <ul class="sf-menu sf-js-enabled">
                <?php foreach ($hot->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor('blog/post/' . $item->PostID, $item->PostTitle) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tabs_last tabs_list">
            <ul class="sf-menu sf-js-enabled" >
                <?php foreach ($last->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor('blog/post/' . $item->PostID, $item->PostTitle) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tabs_comment tabs_list">
            <ul class="sf-menu sf-js-enabled">
                <?php foreach ($comment->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor('blog/post/' . $item->PostID . '#' . $item->CommentID, $item->CommentBody) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tabs_guest tabs_list">
            <ul class="sf-menu sf-js-enabled" >
                <?php foreach ($guest->result() as $item): ?>
                    <li class="cat-item"><?php echo anchor('guest', $item->GuestBody); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!--/content -->
</div>
<!--/box -->