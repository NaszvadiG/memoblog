<div id="header">
        <div class="logo">
            <h1><a name=""><b>老龟的沙滩</b> <i>MeMo Blog</i></a></h1>
        </div>
        <!--/logo -->
        <div class="clr"></div>
        <div class="topnav">
                <ul id="topnav">
                        <li><?php echo anchor('', '<span>首页</span>'); ?></li>
                        <li><?php echo anchor('blog', '<span>博客</span>'); ?></li>
                        <li><?php echo anchor('other', '<span>其他</span>'); ?></li>
                        <li><?php echo anchor('guest', '<span>留言</span>'); ?></li>
                        <li><?php echo anchor('about', '<span>关于</span>'); ?></li>
                </ul>
                <div class="clr"></div>
        </div>
        <!--/topnav -->
		<script type="text/javascript" language="javascript">
        var nav = document.getElementById("topnav");
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
        links[last].className = "current_page_item";
    </script>
        <form method="get" id="searchform" action="blog/search">
                <fieldset id="search">
                        <span>
                                <input type="hidden" name="type" value="title"/>
                                <input type="text" value="你懂的..." onclick="this.value='';" name="id" id="s" />
                                <input type="image" src="../public/images/search.gif" value="我搜" id="searchsubmit" class="btn"  />
                        </span>
                </fieldset>
        </form>
        <!--/searchform -->
        <!--
<div class="clr"></div>
<div class="header_h2">
        <div class="clr"></div>
        <div class="slider_bottom"> <a href="###"><img src="../public/images/test.gif" alt="" width="36" height="33" border="0" /></a>
                <p>每天一个名言锦句。<br />
                        <strong>谁谁谁</strong></p>
        </div>
</div>
        <!--/header_h2 -->
        <br/>
        <br/>
        <div class="clr"></div>
</div>