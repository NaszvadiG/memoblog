/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : memo

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2011-07-12 13:13:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `jf_comment`
-- ----------------------------
DROP TABLE IF EXISTS `jf_comment`;
CREATE TABLE `jf_comment` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `PostID` int(11) NOT NULL,
  `CommentBody` text NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL,
  `ReplyTime` datetime DEFAULT NULL,
  `ReplyBody` tinytext,
  PRIMARY KEY (`CommentID`,`PostID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `jf_guest`
-- ----------------------------
DROP TABLE IF EXISTS `jf_guest`;
CREATE TABLE `jf_guest` (
  `GuestID` int(11) NOT NULL AUTO_INCREMENT,
  `GuestBody` tinytext NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '0',
  `ReplyBody` tinytext,
  `ReplyTime` datetime DEFAULT NULL,
  PRIMARY KEY (`GuestID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_guest
-- ----------------------------

-- ----------------------------
-- Table structure for `jf_isshow`
-- ----------------------------
DROP TABLE IF EXISTS `jf_isshow`;
CREATE TABLE `jf_isshow` (
  `IsShowID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `IsShowName` char(25) NOT NULL,
  `IsShowOrder` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`IsShowID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_isshow
-- ----------------------------
INSERT INTO `jf_isshow` VALUES ('1', '私密文章', '0');
INSERT INTO `jf_isshow` VALUES ('2', '草稿文章', '0');
INSERT INTO `jf_isshow` VALUES ('3', '正常发表', '0');
INSERT INTO `jf_isshow` VALUES ('4', '优先推荐', '0');

-- ----------------------------
-- Table structure for `jf_link`
-- ----------------------------
DROP TABLE IF EXISTS `jf_link`;
CREATE TABLE `jf_link` (
  `LinkID` smallint(6) NOT NULL AUTO_INCREMENT,
  `LinkName` varchar(50) NOT NULL,
  `LinkUrl` varchar(255) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '0',
  `LinkOrder` smallint(6) DEFAULT '0',
  PRIMARY KEY (`LinkID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_link
-- ----------------------------
INSERT INTO `jf_link` VALUES ('1', '老龟的沙滩', 'http://www.justfree.org.cn', '幽蓝冰魄', 'alex.royce315@gmail.com', '2011-07-12 11:07:33', '192.168.1.150', '1', '0');

-- ----------------------------
-- Table structure for `jf_log`
-- ----------------------------
DROP TABLE IF EXISTS `jf_log`;
CREATE TABLE `jf_log` (
  `LogID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` smallint(6) NOT NULL,
  `LogAction` varchar(255) NOT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  PRIMARY KEY (`LogID`,`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_log
-- ----------------------------

-- ----------------------------
-- Table structure for `jf_other`
-- ----------------------------
DROP TABLE IF EXISTS `jf_other`;
CREATE TABLE `jf_other` (
  `OtherID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `OtherName` varchar(255) NOT NULL,
  `OtherAbout` tinytext,
  `HtmlUrl` varchar(255) NOT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '3',
  PRIMARY KEY (`OtherID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_other
-- ----------------------------

-- ----------------------------
-- Table structure for `jf_post`
-- ----------------------------
DROP TABLE IF EXISTS `jf_post`;
CREATE TABLE `jf_post` (
  `PostID` int(11) NOT NULL AUTO_INCREMENT,
  `PostTitle` varchar(255) NOT NULL,
  `SortID` smallint(6) NOT NULL,
  `UserID` smallint(6) NOT NULL,
  `PostAbout` varchar(2550) NOT NULL,
  `ReadNum` int(11) DEFAULT '0',
  `Comment` int(11) DEFAULT '0',
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '3',
  `Password` char(10) DEFAULT NULL,
  `PostBody` text NOT NULL,
  `TagID` varchar(255) DEFAULT NULL,
  `TagName` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`PostID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_post
-- ----------------------------
INSERT INTO `jf_post` VALUES ('1', '昨天调戏诈骗的，今天发布 MeMo', '1', '1', '然后，来到今天发布 MeMo 主题。上面说到，这个是昨天写完了的。主要完成了前台 ajax 提交、无限级分类和标签等功能，并且还留下了若干彩蛋。虽然程序非常简单，我可不想程序员就这么不加思考地拿来就用。虽然对全局使用影响不大，但能完善了都是好的。至于彩蛋么，一个是空白页面，另一个是一系列的全选、取消，还有的等待大家发掘。', '5', '0', '2011-07-12 11:07:08', '192.168.1.150', '3', null, '<div>昨天，公元 2011 年 7 月 10 日，下午 1 点 40 分，接到一号码为 4006012662 的电话，内容为一段录音：您有包裹，因地址不详无法投递，请联系 020-81162409，请联系 020-81162409，请联系 020-81162409 ……。我心想，谁有事没事儿的给我寄包裹，心里好奇，而且这个电话号码有古怪；加之周末闲着没事做，正准备睡午觉呢，听到这个开始来劲了。所以，两分钟之后我开始按照提供的电话打过去。三声铃响之后，有一母鸭嗓子声音响起：这里是中国邮政，请问您有什么事情。我：刚刚接到电话通知，说有我的包裹。母鸭嗓子：好的，我帮您查一下；请提供您的号码和姓名。我：号码就是这个，免贵姓刘。母鸭嗓子：您稍等，请不要挂断电话。几秒之后，母鸭嗓子：先生您好，您有一份来自云南的包裹。因为安检时发现其中有很多小包装并有白色粉末泄漏，属于国家违禁产品,已经被广州市公安局查扣。我：哦，云南的包裹。母鸭嗓子：是，云南的包裹。因为安检时发现其中有很多小包装并有白色粉末泄漏，属于国家违禁产品已经被广州市公安局查扣。我：收件人是谁，电话号码呢？母鸭嗓子：收件人是一位姓刘的先生，电话号码是 ×××× 。我：收件人是谁？母鸭嗓子：收件人是一位姓刘的先生。我：听不清楚，麻烦重复一遍？母鸭嗓子：先生您好，您有一份来自云南的包裹。因为安检时发现其中有很多小包装并有白色粉末泄漏，属于国家违禁产品已经被广州市公安局查扣。我：是么？我现在就在公安局。在半秒钟之内，那边挂断了电话。</div>\r\n<div><br />\r\n</div>\r\n<div>这就是调戏骗子的经过，仅供各位朋友参考。</div>\r\n<div><br />\r\n</div>\r\n<div>话说这年头人们的生活水平提高了，知识能力和思想素质也提高了，骗子伎俩的长进却没啥明显的改观。这个小小的娱乐过程中有很多的漏洞可循。1、尽管由于监管等诸多方面的漏洞，400 电话早已是众多骗子公司的外包装伎俩。但是，既然是中国邮政，打电话过来的也不应该是这个号码，至少是中国邮政的官方号码吧。2、 400 电话的录音内容，为了让你明确下一步的联系电话，不惜重复了六七遍之多，如果是中国邮政，应该给个提示说重复请按什么键，查询请按什么键，人工服务请按什么键之类的。3、81162409 的母鸭嗓子有很大的问题。A、中国邮政的直接联系方式应该是唯一的官方多线总机，并且有语音数字提示然后分转，就算为了方便直接给个分营店的电话的话请直接看下一条。B、邮政、电信这类的公有企业最不差的就是钱，所以找个把美貌、甜美声音的客服不在话下，即便不美貌，客服都经过专业、职业的培训，声音的发声、音质、措辞等都会有很严格的讲究。就算这方面都有欠缺，至少也不会找个母鸭嗓子来做客服。C、客服查询过程诡异，整个查询过程中没有听到任何键盘敲击声音，没有其他客服回复或客户咨询的杂声。D、母鸭嗓子回答诡异，在询问收件人和联系电话时直接复述先前索要的联系电话和姓名，而无法准确提供具体姓名也未说明单号及相关更为详细的资料。E、违禁物品被广州市公安局查扣，如果是毒品什么的应该是缉毒什么职能部门吧，当然这么说也无可厚非，毕竟都是同属公安、警察一个系列，可疑的是听到我在公安局的时候就立马收线，我都还没说清楚在那个公安局抑或分局什么的，甚至我根本就不在广州呢，心虚什么嘛，应该继续演呀。F、更为诡异的是我从未去过云南，这些骗子也不做一下前期的功课，估计直接买来一堆电话就开始狂轰滥炸，然后利用部分人心里有鬼就开始钓鱼上钩，伺机大发不义横财。不说了，再说下去我成专业犯罪教唆者了。</div>\r\n<div>昨天心情愉快，因为 MeMo 已经基本写完了。所以饶过这伙骗子，要是哪天心情不好的时候再给我撞到，直接揪出来送派出所。</div>\r\n<div><br />\r\n</div>\r\n<div>然后，来到今天发布 MeMo 主题。上面说到，这个是昨天写完了的。主要完成了前台 ajax 提交、无限级分类和标签等功能，并且还留下了若干彩蛋。虽然程序非常简单，我可不想程序员就这么不加思考地拿来就用。虽然对全局使用影响不大，但能完善了都是好的。至于彩蛋么，一个是空白页面，另一个是一系列的全选、取消，还有的等待大家发掘。</div>\r\n<div><br />\r\n</div>\r\n<div>这之后会继续开发一个企业系统，不开源。但是，其中采用的权限控制系统会开源。该权限控制系统将源自目前筹划的系统，是其 lite 版本。再然后，会考虑开发一个无权限的调查系统。当然了，所有发布时间未定，可能今年，也可能几年之后。</div>\r\n<div><br />\r\n</div>\r\n<div>MeMo 的开发平台：Windows 7 Professional SP1 / NetBeans 7 for PHP / Notepad ++ 5.9.2 / IE 9.0.1 / Chrome 12.0.742.112 / xampp 1.7.4 (如无特殊情况，所采用的平台均为当前稳定版最新版本)</div>', '', 'MeMo|Wen|开源|CodeIgniter');

-- ----------------------------
-- Table structure for `jf_sort`
-- ----------------------------
DROP TABLE IF EXISTS `jf_sort`;
CREATE TABLE `jf_sort` (
  `SortID` smallint(6) NOT NULL AUTO_INCREMENT,
  `SortName` varchar(25) NOT NULL,
  `SortOrder` smallint(6) DEFAULT '0',
  `ParentID` smallint(6) NOT NULL,
  `SortLevel` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SortID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_sort
-- ----------------------------
INSERT INTO `jf_sort` VALUES ('1', '一级分类', '0', '0', '1', '1');
INSERT INTO `jf_sort` VALUES ('2', '二级分类 1', '0', '1', '1|2', '1');
INSERT INTO `jf_sort` VALUES ('3', '三级分类 1', '0', '2', '1|2|3', '1');
INSERT INTO `jf_sort` VALUES ('4', '一级分类 2', '0', '0', '4', '1');

-- ----------------------------
-- Table structure for `jf_tag`
-- ----------------------------
DROP TABLE IF EXISTS `jf_tag`;
CREATE TABLE `jf_tag` (
  `TagID` int(11) NOT NULL AUTO_INCREMENT,
  `TagName` char(50) NOT NULL,
  `ReadNum` int(11) DEFAULT '0',
  PRIMARY KEY (`TagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `jf_user`
-- ----------------------------
DROP TABLE IF EXISTS `jf_user`;
CREATE TABLE `jf_user` (
  `UserID` smallint(6) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `WebSite` varchar(255) DEFAULT NULL,
  `AddTime` datetime NOT NULL,
  `AddIP` char(25) NOT NULL,
  `IsShowID` tinyint(4) NOT NULL DEFAULT '0',
  `LastLogTime` datetime DEFAULT NULL,
  `LastLogIP` char(25) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `LogTimes` int(11) DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jf_user
-- ----------------------------
INSERT INTO `jf_user` VALUES ('1', 'admin', 'alex.royce315@gmail.com', 'http://www.justfree.org.cn', '2011-07-12 11:40:33', '192.168.1.20', '1', '2011-07-12 11:51:53', '192.168.1.150', '61152c80d1514e22fba66002597d0104', '2');
