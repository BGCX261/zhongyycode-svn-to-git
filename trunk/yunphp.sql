-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2009 年 11 月 05 日 03:04
-- 服务器版本: 5.0.27
-- PHP 版本: 5.2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `yunphp`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `acl`
-- 

CREATE TABLE `acl` (
  `acl_id` int(11) NOT NULL auto_increment COMMENT '主键',
  `rule_id` int(11) NOT NULL COMMENT '规则ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `permit` tinyint(1) NOT NULL default '0' COMMENT '权限许可',
  PRIMARY KEY  (`acl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ACL 访问控制表' AUTO_INCREMENT=172 ;

-- 
-- 导出表中的数据 `acl`
-- 

INSERT INTO `acl` VALUES (1, 1, 1, 0);
INSERT INTO `acl` VALUES (2, 1, 2, 0);
INSERT INTO `acl` VALUES (3, 1, 3, 1);
INSERT INTO `acl` VALUES (4, 1, 4, 1);
INSERT INTO `acl` VALUES (5, 1, 17, 0);
INSERT INTO `acl` VALUES (6, 1, 16, 0);
INSERT INTO `acl` VALUES (7, 1, 7, 0);
INSERT INTO `acl` VALUES (8, 1, 5, 1);
INSERT INTO `acl` VALUES (9, 1, 6, 1);
INSERT INTO `acl` VALUES (10, 2, 1, 0);
INSERT INTO `acl` VALUES (11, 2, 2, 0);
INSERT INTO `acl` VALUES (12, 2, 3, 0);
INSERT INTO `acl` VALUES (13, 2, 4, 0);
INSERT INTO `acl` VALUES (14, 2, 17, 0);
INSERT INTO `acl` VALUES (15, 2, 16, 0);
INSERT INTO `acl` VALUES (16, 2, 7, 0);
INSERT INTO `acl` VALUES (17, 2, 5, 1);
INSERT INTO `acl` VALUES (18, 2, 6, 1);
INSERT INTO `acl` VALUES (19, 3, 1, 1);
INSERT INTO `acl` VALUES (20, 3, 2, 0);
INSERT INTO `acl` VALUES (21, 3, 3, 0);
INSERT INTO `acl` VALUES (22, 3, 4, 0);
INSERT INTO `acl` VALUES (23, 3, 17, 0);
INSERT INTO `acl` VALUES (24, 3, 16, 0);
INSERT INTO `acl` VALUES (25, 3, 7, 0);
INSERT INTO `acl` VALUES (26, 3, 5, 1);
INSERT INTO `acl` VALUES (27, 3, 6, 1);
INSERT INTO `acl` VALUES (28, 4, 1, 0);
INSERT INTO `acl` VALUES (29, 4, 2, 0);
INSERT INTO `acl` VALUES (30, 4, 3, 1);
INSERT INTO `acl` VALUES (31, 4, 4, 1);
INSERT INTO `acl` VALUES (32, 4, 17, 0);
INSERT INTO `acl` VALUES (33, 4, 16, 0);
INSERT INTO `acl` VALUES (34, 4, 7, 0);
INSERT INTO `acl` VALUES (35, 4, 5, 1);
INSERT INTO `acl` VALUES (36, 4, 6, 1);
INSERT INTO `acl` VALUES (37, 5, 1, 0);
INSERT INTO `acl` VALUES (38, 5, 2, 0);
INSERT INTO `acl` VALUES (39, 5, 3, 0);
INSERT INTO `acl` VALUES (40, 5, 4, 0);
INSERT INTO `acl` VALUES (41, 5, 17, 0);
INSERT INTO `acl` VALUES (42, 5, 16, 0);
INSERT INTO `acl` VALUES (43, 5, 7, 0);
INSERT INTO `acl` VALUES (44, 5, 5, 1);
INSERT INTO `acl` VALUES (45, 5, 6, 1);
INSERT INTO `acl` VALUES (46, 6, 1, 0);
INSERT INTO `acl` VALUES (47, 6, 2, 0);
INSERT INTO `acl` VALUES (48, 6, 3, 0);
INSERT INTO `acl` VALUES (49, 6, 4, 1);
INSERT INTO `acl` VALUES (50, 6, 17, 0);
INSERT INTO `acl` VALUES (51, 6, 16, 0);
INSERT INTO `acl` VALUES (52, 6, 7, 0);
INSERT INTO `acl` VALUES (53, 6, 5, 1);
INSERT INTO `acl` VALUES (54, 6, 6, 1);
INSERT INTO `acl` VALUES (55, 7, 1, 0);
INSERT INTO `acl` VALUES (56, 7, 2, 0);
INSERT INTO `acl` VALUES (57, 7, 3, 0);
INSERT INTO `acl` VALUES (58, 7, 4, 0);
INSERT INTO `acl` VALUES (59, 7, 17, 0);
INSERT INTO `acl` VALUES (60, 7, 16, 0);
INSERT INTO `acl` VALUES (61, 7, 7, 0);
INSERT INTO `acl` VALUES (62, 7, 5, 1);
INSERT INTO `acl` VALUES (63, 7, 6, 1);
INSERT INTO `acl` VALUES (64, 8, 1, 0);
INSERT INTO `acl` VALUES (65, 8, 2, 0);
INSERT INTO `acl` VALUES (66, 8, 3, 0);
INSERT INTO `acl` VALUES (67, 8, 4, 0);
INSERT INTO `acl` VALUES (68, 8, 17, 0);
INSERT INTO `acl` VALUES (69, 8, 16, 0);
INSERT INTO `acl` VALUES (70, 8, 7, 0);
INSERT INTO `acl` VALUES (71, 8, 5, 1);
INSERT INTO `acl` VALUES (72, 8, 6, 1);
INSERT INTO `acl` VALUES (73, 9, 1, 0);
INSERT INTO `acl` VALUES (74, 9, 2, 0);
INSERT INTO `acl` VALUES (75, 9, 3, 0);
INSERT INTO `acl` VALUES (76, 9, 4, 0);
INSERT INTO `acl` VALUES (77, 9, 17, 0);
INSERT INTO `acl` VALUES (78, 9, 16, 0);
INSERT INTO `acl` VALUES (79, 9, 7, 0);
INSERT INTO `acl` VALUES (80, 9, 5, 1);
INSERT INTO `acl` VALUES (81, 9, 6, 1);
INSERT INTO `acl` VALUES (82, 10, 1, 0);
INSERT INTO `acl` VALUES (83, 10, 2, 0);
INSERT INTO `acl` VALUES (84, 10, 3, 0);
INSERT INTO `acl` VALUES (85, 10, 4, 0);
INSERT INTO `acl` VALUES (86, 10, 17, 0);
INSERT INTO `acl` VALUES (87, 10, 16, 0);
INSERT INTO `acl` VALUES (88, 10, 7, 0);
INSERT INTO `acl` VALUES (89, 10, 5, 1);
INSERT INTO `acl` VALUES (90, 10, 6, 1);
INSERT INTO `acl` VALUES (91, 11, 1, 0);
INSERT INTO `acl` VALUES (92, 11, 2, 0);
INSERT INTO `acl` VALUES (93, 11, 3, 1);
INSERT INTO `acl` VALUES (94, 11, 4, 1);
INSERT INTO `acl` VALUES (95, 11, 17, 0);
INSERT INTO `acl` VALUES (96, 11, 16, 0);
INSERT INTO `acl` VALUES (97, 11, 7, 0);
INSERT INTO `acl` VALUES (98, 11, 5, 1);
INSERT INTO `acl` VALUES (99, 11, 6, 1);
INSERT INTO `acl` VALUES (100, 12, 1, 0);
INSERT INTO `acl` VALUES (101, 12, 2, 0);
INSERT INTO `acl` VALUES (102, 12, 3, 1);
INSERT INTO `acl` VALUES (103, 12, 4, 0);
INSERT INTO `acl` VALUES (104, 12, 17, 0);
INSERT INTO `acl` VALUES (105, 12, 16, 0);
INSERT INTO `acl` VALUES (106, 12, 7, 0);
INSERT INTO `acl` VALUES (107, 12, 5, 1);
INSERT INTO `acl` VALUES (108, 12, 6, 1);
INSERT INTO `acl` VALUES (109, 13, 1, 0);
INSERT INTO `acl` VALUES (110, 13, 2, 0);
INSERT INTO `acl` VALUES (111, 13, 3, 1);
INSERT INTO `acl` VALUES (112, 13, 4, 1);
INSERT INTO `acl` VALUES (113, 13, 17, 0);
INSERT INTO `acl` VALUES (114, 13, 16, 0);
INSERT INTO `acl` VALUES (115, 13, 7, 0);
INSERT INTO `acl` VALUES (116, 13, 5, 1);
INSERT INTO `acl` VALUES (117, 13, 6, 1);
INSERT INTO `acl` VALUES (118, 14, 1, 0);
INSERT INTO `acl` VALUES (119, 14, 2, 0);
INSERT INTO `acl` VALUES (120, 14, 3, 1);
INSERT INTO `acl` VALUES (121, 14, 4, 1);
INSERT INTO `acl` VALUES (122, 14, 17, 0);
INSERT INTO `acl` VALUES (123, 14, 16, 0);
INSERT INTO `acl` VALUES (124, 14, 7, 0);
INSERT INTO `acl` VALUES (125, 14, 5, 1);
INSERT INTO `acl` VALUES (126, 14, 6, 1);
INSERT INTO `acl` VALUES (127, 15, 1, 0);
INSERT INTO `acl` VALUES (128, 15, 2, 0);
INSERT INTO `acl` VALUES (129, 15, 3, 0);
INSERT INTO `acl` VALUES (130, 15, 4, 0);
INSERT INTO `acl` VALUES (131, 15, 17, 0);
INSERT INTO `acl` VALUES (132, 15, 16, 0);
INSERT INTO `acl` VALUES (133, 15, 7, 0);
INSERT INTO `acl` VALUES (134, 15, 5, 1);
INSERT INTO `acl` VALUES (135, 15, 6, 1);
INSERT INTO `acl` VALUES (136, 16, 1, 0);
INSERT INTO `acl` VALUES (137, 16, 2, 0);
INSERT INTO `acl` VALUES (138, 16, 3, 0);
INSERT INTO `acl` VALUES (139, 16, 4, 0);
INSERT INTO `acl` VALUES (140, 16, 17, 0);
INSERT INTO `acl` VALUES (141, 16, 16, 0);
INSERT INTO `acl` VALUES (142, 16, 7, 0);
INSERT INTO `acl` VALUES (143, 16, 5, 1);
INSERT INTO `acl` VALUES (144, 16, 6, 1);
INSERT INTO `acl` VALUES (145, 17, 1, 0);
INSERT INTO `acl` VALUES (146, 17, 2, 0);
INSERT INTO `acl` VALUES (147, 17, 3, 0);
INSERT INTO `acl` VALUES (148, 17, 4, 0);
INSERT INTO `acl` VALUES (149, 17, 17, 0);
INSERT INTO `acl` VALUES (150, 17, 16, 0);
INSERT INTO `acl` VALUES (151, 17, 7, 0);
INSERT INTO `acl` VALUES (152, 17, 5, 1);
INSERT INTO `acl` VALUES (153, 17, 6, 1);
INSERT INTO `acl` VALUES (154, 18, 1, 0);
INSERT INTO `acl` VALUES (155, 18, 2, 0);
INSERT INTO `acl` VALUES (156, 18, 3, 0);
INSERT INTO `acl` VALUES (157, 18, 4, 0);
INSERT INTO `acl` VALUES (158, 18, 17, 0);
INSERT INTO `acl` VALUES (159, 18, 16, 0);
INSERT INTO `acl` VALUES (160, 18, 7, 0);
INSERT INTO `acl` VALUES (161, 18, 5, 1);
INSERT INTO `acl` VALUES (162, 18, 6, 1);
INSERT INTO `acl` VALUES (163, 19, 1, 0);
INSERT INTO `acl` VALUES (164, 19, 2, 0);
INSERT INTO `acl` VALUES (165, 19, 3, 0);
INSERT INTO `acl` VALUES (166, 19, 4, 0);
INSERT INTO `acl` VALUES (167, 19, 17, 0);
INSERT INTO `acl` VALUES (168, 19, 16, 0);
INSERT INTO `acl` VALUES (169, 19, 7, 0);
INSERT INTO `acl` VALUES (170, 19, 5, 1);
INSERT INTO `acl` VALUES (171, 19, 6, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `acl_module`
-- 

CREATE TABLE `acl_module` (
  `mod_name` char(10) NOT NULL COMMENT '模块名称',
  `mod_desc` varchar(30) NOT NULL COMMENT '模块说明',
  PRIMARY KEY  (`mod_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='项目模块';

-- 
-- 导出表中的数据 `acl_module`
-- 

INSERT INTO `acl_module` VALUES ('admin', '管理后台');
INSERT INTO `acl_module` VALUES ('default', '前台页面');

-- --------------------------------------------------------

-- 
-- 表的结构 `acl_privilege`
-- 

CREATE TABLE `acl_privilege` (
  `priv_name` char(10) NOT NULL COMMENT '权限名称',
  `priv_desc` varchar(20) NOT NULL COMMENT '权限说明',
  PRIMARY KEY  (`priv_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作权限';

-- 
-- 导出表中的数据 `acl_privilege`
-- 

INSERT INTO `acl_privilege` VALUES ('view', '查看');
INSERT INTO `acl_privilege` VALUES ('list', '列表');
INSERT INTO `acl_privilege` VALUES ('display', '显示');
INSERT INTO `acl_privilege` VALUES ('insert', '插入');
INSERT INTO `acl_privilege` VALUES ('create', '创建');
INSERT INTO `acl_privilege` VALUES ('save', '保存');
INSERT INTO `acl_privilege` VALUES ('edit', '编辑');
INSERT INTO `acl_privilege` VALUES ('modify', '修改');
INSERT INTO `acl_privilege` VALUES ('update', '更新');
INSERT INTO `acl_privilege` VALUES ('reset', '重置');
INSERT INTO `acl_privilege` VALUES ('delete', '删除');
INSERT INTO `acl_privilege` VALUES ('clean', '清空');
INSERT INTO `acl_privilege` VALUES ('clear', '清除');
INSERT INTO `acl_privilege` VALUES ('access', '访问');
INSERT INTO `acl_privilege` VALUES ('set', '设置');
INSERT INTO `acl_privilege` VALUES ('post', '发表');
INSERT INTO `acl_privilege` VALUES ('search', '搜索');
INSERT INTO `acl_privilege` VALUES ('upload', '上传');
INSERT INTO `acl_privilege` VALUES ('transfer', '转移');
INSERT INTO `acl_privilege` VALUES ('send', '发送');
INSERT INTO `acl_privilege` VALUES ('optimize', '优化');
INSERT INTO `acl_privilege` VALUES ('merge', '合并');
INSERT INTO `acl_privilege` VALUES ('open', '打开');
INSERT INTO `acl_privilege` VALUES ('close', '关闭');
INSERT INTO `acl_privilege` VALUES ('vote', '投票');

-- --------------------------------------------------------

-- 
-- 表的结构 `acl_resource`
-- 

CREATE TABLE `acl_resource` (
  `mod_name` char(10) NOT NULL COMMENT '模块名称',
  `res_name` char(15) NOT NULL COMMENT '资源名称',
  `res_desc` varchar(30) NOT NULL COMMENT '资源说明',
  PRIMARY KEY  (`mod_name`,`res_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ACL 资源表';

-- 
-- 导出表中的数据 `acl_resource`
-- 

INSERT INTO `acl_resource` VALUES ('admin', 'index', '管理界面');
INSERT INTO `acl_resource` VALUES ('admin', 'user', '用户中心');
INSERT INTO `acl_resource` VALUES ('admin', 'system', '系统管理');
INSERT INTO `acl_resource` VALUES ('admin', 'article', '文章管理');
INSERT INTO `acl_resource` VALUES ('admin', 'mail', '邮件管理');

-- --------------------------------------------------------

-- 
-- 表的结构 `acl_role`
-- 

CREATE TABLE `acl_role` (
  `role_id` int(11) NOT NULL auto_increment COMMENT '主键',
  `mod_name` char(10) NOT NULL COMMENT '模块名称',
  `role_name` char(15) NOT NULL COMMENT '角色名称',
  `role_desc` varchar(30) NOT NULL COMMENT '角色说明',
  `role_level` smallint(6) NOT NULL default '0' COMMENT '角色等级',
  `is_guest` tinyint(1) NOT NULL default '0' COMMENT '是否游客',
  `is_default` tinyint(1) NOT NULL default '0' COMMENT '是否默认角色',
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ACL 权限角色表' AUTO_INCREMENT=20 ;

-- 
-- 导出表中的数据 `acl_role`
-- 

INSERT INTO `acl_role` VALUES (1, 'admin', 'guest', '游客', 0, 1, 0);
INSERT INTO `acl_role` VALUES (2, 'admin', 'user', '普通用户', 1, 0, 1);
INSERT INTO `acl_role` VALUES (3, 'admin', 'editor', '编辑员', 2, 0, 0);
INSERT INTO `acl_role` VALUES (4, 'admin', 'operator', '操作员', 3, 0, 0);
INSERT INTO `acl_role` VALUES (5, 'admin', 'administrator', '管理员', 7, 0, 0);
INSERT INTO `acl_role` VALUES (6, 'admin', 'developer', '开发人员', 8, 0, 0);
INSERT INTO `acl_role` VALUES (7, 'admin', 'tester', '测试人员', 6, 0, 0);
INSERT INTO `acl_role` VALUES (19, 'default', 'user', '注册用户', 1, 0, 1);
INSERT INTO `acl_role` VALUES (16, 'admin', 'finance', '财务人员', 5, 0, 0);
INSERT INTO `acl_role` VALUES (17, 'admin', 'stockman', '仓库管理员', 4, 0, 0);
INSERT INTO `acl_role` VALUES (18, 'default', 'guest', '游客', 0, 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `acl_rule`
-- 

CREATE TABLE `acl_rule` (
  `rule_id` int(11) NOT NULL auto_increment COMMENT '主键',
  `res_name` char(15) NOT NULL COMMENT '资源名称',
  `priv_name` char(15) NOT NULL COMMENT '权限名称',
  PRIMARY KEY  (`rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='ACL 规则表' AUTO_INCREMENT=20 ;

-- 
-- 导出表中的数据 `acl_rule`
-- 

INSERT INTO `acl_rule` VALUES (1, 'index', 'access');
INSERT INTO `acl_rule` VALUES (2, 'user', 'clean');
INSERT INTO `acl_rule` VALUES (3, 'user', 'insert');
INSERT INTO `acl_rule` VALUES (4, 'user', 'access');
INSERT INTO `acl_rule` VALUES (5, 'user', 'delete');
INSERT INTO `acl_rule` VALUES (6, 'system', 'access');
INSERT INTO `acl_rule` VALUES (7, 'system', 'delete');
INSERT INTO `acl_rule` VALUES (8, 'system', 'edit');
INSERT INTO `acl_rule` VALUES (9, 'system', 'insert');
INSERT INTO `acl_rule` VALUES (10, 'system', 'set');
INSERT INTO `acl_rule` VALUES (11, 'article', 'access');
INSERT INTO `acl_rule` VALUES (12, 'article', 'delete');
INSERT INTO `acl_rule` VALUES (13, 'article', 'edit');
INSERT INTO `acl_rule` VALUES (14, 'article', 'insert');
INSERT INTO `acl_rule` VALUES (15, 'system', 'display');
INSERT INTO `acl_rule` VALUES (16, 'mail', 'access');
INSERT INTO `acl_rule` VALUES (17, 'mail', 'send');
INSERT INTO `acl_rule` VALUES (18, 'mail', 'set');
INSERT INTO `acl_rule` VALUES (19, 'user', 'clear');

-- --------------------------------------------------------

-- 
-- 表的结构 `article`
-- 

CREATE TABLE `article` (
  `art_id` int(11) NOT NULL auto_increment COMMENT '文章ID',
  `author` int(11) NOT NULL COMMENT '作者',
  `title` varchar(250) NOT NULL COMMENT '文章标题',
  `brief` tinytext NOT NULL COMMENT '摘要',
  `content` text NOT NULL COMMENT '正文',
  `cate_id` int(11) NOT NULL default '0' COMMENT '类别ID',
  `clicks` int(11) NOT NULL default '0' COMMENT '点击数',
  `comments` int(11) NOT NULL default '0' COMMENT '评论数',
  `is_key` tinyint(1) NOT NULL default '0' COMMENT '是否重点推荐',
  `is_show` tinyint(1) NOT NULL default '0' COMMENT '是否显示',
  `save_time` int(11) NOT NULL COMMENT '发表时间',
  `modify_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`art_id`),
  KEY `uid` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章表' AUTO_INCREMENT=45 ;

-- 
-- 导出表中的数据 `article`
-- 

INSERT INTO `article` VALUES (1, 0, '[惊爆]游戏人间泡妞记录[转载]', '西门小雪：你在吗？怎么不见你上线？\r\n游戏人间：心无时不跳，我无处不在。\r\n\r\n西门小雪：原来是个“隐君子”\r\n游戏人间：隐名免灾祸，隐身免烦恼。\r\n\r\n西门小雪：不知道“小隐于野，大隐', '<p>西门小雪：你在吗？怎么不见你上线？ <br />\r\n游戏人间：心无时不跳，我无处不在。 <br />\r\n<br />\r\n西门小雪：原来是个&ldquo;隐君子&rdquo; <br />\r\n游戏人间：隐名免灾祸，隐身免烦恼。 <br />\r\n<br />\r\n西门小雪：不知道&ldquo;小隐于野，大隐于市&rdquo;吗？ <br />\r\n游戏人间：知人知面不知心，隐名隐身难隐情。 <br />\r\n<br />\r\n西门小雪：哇，好难懂啊，你学哲学的？ <br />\r\n游戏人间：学文学的都是傻子，学哲学的都是疯子。 <br />\r\n<br />\r\n西门小雪：真精辟啊，你是不是经常这样在网上泡妞？ <br />\r\n游戏人间：流汗流血不流泪，泡茶泡吧不泡妞。 <br />\r\n<br />\r\n西门小雪：好酷呀，可是人不可能没有感情呀！ <br />\r\n游戏人间：蒸桑拿蒸馒头不争名利，弹吉它弹棉花不谈感情 <br />\r\n<br />\r\n西门小雪：我开始流汗了，你真是个牛人！ <br />\r\n游戏人间：玩什么都别玩爱情，信什么也别信男人。 <br />\r\n<br />\r\n西门小雪：嗯，至理名言，你受过感情的伤呀？ <br />\r\n游戏人间：爱有多深，恨有多深。 <br />\r\n<br />\r\n西门小雪：怎么感觉那么沧桑啊。 <br />\r\n游戏人间：女人因为成熟而沧桑，男人因为沧桑而成熟。 <br />\r\n<br />\r\n西门小雪：有点难懂，但又很有道理。 <br />\r\n游戏人间：男人善于花言巧语，女人喜欢花前月下。 <br />\r\n<br />\r\n西门小雪：你是怪物吧！ <br />\r\n游戏人间：每个人都是怪物，每句话都是真理。 <br />\r\n<br />\r\n西门小雪：天啊，和你生活在一起会累死了，肯定没人会嫁给你。 <br />\r\n游戏人间：笨男人要结婚，笨女人要减肥。 <br />\r\n<br />\r\n西门小雪：我要哭了！ <br />\r\n游戏人间：爱与恨都是寂寞的空气，哭与笑表达同样的意义。 <br />\r\n<br />\r\n西门小雪：哭和笑怎么能一样，去死吧！ <br />\r\n游戏人间：苦与乐都是财富，生与死都要绚丽。 <br />\r\n<br />\r\n西门小雪：和你说话真累，其实你不懂女人心。 <br />\r\n游戏人间：女人希望男人表露心灵，男人希望女人裸露身体。 <br />\r\n<br />\r\n西门小雪：嗯这句话有道理，你有没有女朋友？ <br />\r\n游戏人间：黄脸老婆易寻，红颜知己难觅。 <br />\r\n<br />\r\n西门小雪：和你结婚会不会开心？ <br />\r\n游戏人间：男人的痛苦从结婚开始，女人的痛苦从认识男人开始。 <br />\r\n<br />\r\n西门小雪：天啊，那还是不要接近你了&hellip;&hellip; <br />\r\n游戏人间：最易接近的是身体，最难接近的是心灵。 <br />\r\n<br />\r\n西门小雪：你喜欢怎样的女孩子？ <br />\r\n游戏人间：女人喜欢的男人越成熟越好，男人喜欢的女孩越单纯越好。 <br />\r\n<br />\r\n西门小雪：不是吧，我怎么听说男人对不单纯的女人也感兴趣？ <br />\r\n游戏人间：好男人应在床上勇猛，好女人应在床上放荡。 <br />\r\n<br />\r\n西门小雪：哈哈色狼的尾巴露出来了！ <br />\r\n游戏人间：男人好色称为色狼，男人不好色称为色盲。 <br />\r\n<br />\r\n西门小雪：你讲话很搞笑呀。 <br />\r\n游戏人间：世间纷繁万般无奈，心头只求片刻安宁 <br />\r\n<br />\r\n西门小雪：下次还能和你聊吗？ <br />\r\n游戏人间：做男人无能会使女人寄希望于未来，做女人失败会使男人寄思念于过去 <br />\r\n<br />\r\n西门小雪：哈哈，你的意思是我们现在就见面？ <br />\r\n游戏人间：心动不如行动，说到不如做到。 <br />\r\n<br />\r\n西门小雪：OK，我决定了，去见你！ <br />\r\n游戏人间：有缘人终成正果，有情人终成网友！</p>', 2, 24, 0, 0, 0, 1233983073, 0);
INSERT INTO `article` VALUES (2, 0, '《孟婆汤》', '一条路，叫黄泉\r\n布满哀伤。\r\n一条河，名忘川\r\n流溢凄凉\r\n一座奈何，承载忘川\r\n一碗孟婆汤，可以忘却今生 换取来世\r\n一块石头，立于忘川之畔，名日三世\r\n一口井，指明来世\r\n一个熟悉身影，', '<p>一条路，叫黄泉<br />\r\n布满哀伤。<br />\r\n一条河，名忘川<br />\r\n流溢凄凉<br />\r\n一座奈何，承载忘川<br />\r\n一碗孟婆汤，可以忘却今生 换取来世<br />\r\n一块石头，立于忘川之畔，名日三世<br />\r\n一口井，指明来世<br />\r\n一个熟悉身影，欣然跃下<br />\r\n一张容颜，下辈子<br />\r\n为君倾城</p>', 1, 22, 0, 0, 0, 1233913298, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `article_comment`
-- 

CREATE TABLE `article_comment` (
  `comment_id` int(11) NOT NULL auto_increment COMMENT '评论ID',
  `art_id` int(11) NOT NULL COMMENT '文章ID',
  `comment_name` varchar(25) NOT NULL COMMENT '用户',
  `content` text NOT NULL COMMENT '评论内容',
  `ip` char(15) NOT NULL COMMENT 'IP',
  `add_time` int(11) NOT NULL COMMENT '评论时间',
  PRIMARY KEY  (`comment_id`),
  KEY `goods_id` (`art_id`),
  KEY `uid` (`comment_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章评论' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `article_comment`
-- 

INSERT INTO `article_comment` VALUES (1, 1, 'dd', 'ddd', '', 1237462043);
INSERT INTO `article_comment` VALUES (2, 2, 'd', 'd', '', 1255683893);

-- --------------------------------------------------------

-- 
-- 表的结构 `category`
-- 

CREATE TABLE `category` (
  `cate_id` int(11) NOT NULL auto_increment COMMENT '类别ID，主键，自增',
  `cate_name` varchar(100) NOT NULL COMMENT '类别名称',
  `parent_id` int(11) NOT NULL COMMENT '父类别ID',
  `sort_order` tinyint(4) NOT NULL default '0' COMMENT '排序值',
  `path` varchar(255) default NULL COMMENT '路径，以;分隔',
  `is_show` tinyint(1) NOT NULL default '1' COMMENT '是否显示，0：否，1：是',
  PRIMARY KEY  (`cate_id`),
  KEY `path` (`path`),
  KEY `parent_id` (`parent_id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='类别表' AUTO_INCREMENT=19 ;

-- 
-- 导出表中的数据 `category`
-- 

INSERT INTO `category` VALUES (1, '心情日记', 0, 0, '0;1;', 1);
INSERT INTO `category` VALUES (2, 'php', 0, 0, '0;2;', 1);
INSERT INTO `category` VALUES (3, 'jquery', 0, 0, '0;3;', 1);
INSERT INTO `category` VALUES (4, '留言', 0, 0, '0;4;', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `file`
-- 

CREATE TABLE `file` (
  `file_id` int(11) NOT NULL auto_increment COMMENT '主键',
  `cate_id` int(11) NOT NULL COMMENT '分类ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `upload_time` int(11) NOT NULL COMMENT '上传时间',
  `download` int(11) NOT NULL default '0' COMMENT '下载次数',
  `description` varchar(250) NOT NULL COMMENT '文件描述',
  `filename` varchar(40) NOT NULL COMMENT '文件名',
  `filesize` int(11) NOT NULL COMMENT '文件大小',
  `filetype` varchar(30) NOT NULL COMMENT '文件类型',
  `extension` char(8) NOT NULL COMMENT '扩展名',
  `savename` varchar(50) NOT NULL COMMENT '保存的文件名',
  `is_image` tinyint(1) NOT NULL default '0' COMMENT '是否图片',
  `md5_hash` varchar(32) default NULL COMMENT '文件的md5值',
  PRIMARY KEY  (`file_id`),
  KEY `cate_id` (`cate_id`),
  KEY `md5_hash` (`md5_hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='上传文件管理' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `file`
-- 

INSERT INTO `file` VALUES (1, 1, 2, 1255661141, 0, 'test ', 'loadingAnimation.gif', 5886, 'image/gif', 'gif', 'uploads/public/0910/125566114099.gif', 1, 'c33734a1bf58bec328ffa27872e96ae1');
INSERT INTO `file` VALUES (2, 2, 1, 1255664121, 0, '', '2009-06-02_35302.jpg', 39305, 'image/jpeg', 'jpg', 'uploads/art_img/125566412162.jpg', 1, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `file_category`
-- 

CREATE TABLE `file_category` (
  `cate_id` int(11) NOT NULL auto_increment COMMENT '主键',
  `cate_name` varchar(50) NOT NULL COMMENT '名称',
  `filepath` varchar(100) NOT NULL COMMENT '路径',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `allow_upload` tinyint(1) NOT NULL default '1' COMMENT '允许上传',
  `allow_delete` tinyint(1) NOT NULL default '1' COMMENT '允许删除',
  `file_count` int(11) NOT NULL default '0' COMMENT '文件数统计',
  PRIMARY KEY  (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `file_category`
-- 

INSERT INTO `file_category` VALUES (1, '公共目录', 'public', '存放公共文件目录', 1, 1, 0);
INSERT INTO `file_category` VALUES (2, '文章管理图片', 'art_img', '存放文章信息文件目录', 1, 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `link`
-- 

CREATE TABLE `link` (
  `link_id` int(11) NOT NULL auto_increment,
  `link_name` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `save_time` int(11) NOT NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ucs2 AUTO_INCREMENT=6 ;

-- 
-- 导出表中的数据 `link`
-- 

INSERT INTO `link` VALUES (1, '番茄 Blog', 'http://www.tblog.com.cn/', 1233992477);
INSERT INTO `link` VALUES (2, 'PHP面对对象', 'http://www.phpobject.net/blog/', 1233992532);
INSERT INTO `link` VALUES (3, 'hyper的草稿', 'http://mydraft.cn/\r\n', 1233992567);
INSERT INTO `link` VALUES (4, '艾米丽商城', 'http://shop.imeelee.com', 1240387411);
INSERT INTO `link` VALUES (5, 'test', 'http://act.imeelee.com/user/register', 1247472926);

-- --------------------------------------------------------

-- 
-- 表的结构 `service`
-- 

CREATE TABLE `service` (
  `id` int(11) NOT NULL auto_increment COMMENT '信息ID',
  `post_content` text NOT NULL COMMENT '信息内容',
  `reply_content` text COMMENT '回复内容',
  `post_time` int(11) default NULL COMMENT '发表时间',
  `reply_time` int(11) NOT NULL default '0' COMMENT '回复时间',
  `reply_uid` int(11) NOT NULL default '0' COMMENT '回复ID',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='客服中心表' AUTO_INCREMENT=16 ;

-- 
-- 导出表中的数据 `service`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `user`
-- 

CREATE TABLE `user` (
  `uid` int(10) unsigned NOT NULL auto_increment COMMENT '会员ID',
  `username` varchar(60) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `salt` char(6) default '' COMMENT '密码随机加密串',
  `email` varchar(50) NOT NULL COMMENT '电邮',
  `reg_ip` char(15) NOT NULL COMMENT '注册时的IP',
  `reg_time` int(10) unsigned NOT NULL default '0' COMMENT '注册时间',
  `last_ip` char(15) NOT NULL COMMENT '上一次登录的IP',
  `last_time` int(10) unsigned NOT NULL default '0' COMMENT '上一次登录的时间',
  `avatar` varchar(30) NOT NULL default '/uploads/avatars/noavatar.jpg' COMMENT '头像地址',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='会员主表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `user`
-- 

INSERT INTO `user` VALUES (1, 'zhongyy', '224cf2b695a5e8ecaecfb9015161fa4b', '', '', '', 0, '127.0.0.1', 1257148150, '/uploads/avatars/noavatar.jpg');
INSERT INTO `user` VALUES (2, 'zyy', '14e1b600b1fd579f47433b88e8d85291', '1', '1', '1', 1, '127.0.0.1', 1257148128, '/uploads/avatars/noavatar.jpg');

-- --------------------------------------------------------

-- 
-- 表的结构 `user_role`
-- 

CREATE TABLE `user_role` (
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `mod_name` char(10) NOT NULL COMMENT '模块名称',
  KEY `uid` (`uid`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色';

-- 
-- 导出表中的数据 `user_role`
-- 

INSERT INTO `user_role` VALUES (1, 19, 'default');
INSERT INTO `user_role` VALUES (2, 4, 'admin');
INSERT INTO `user_role` VALUES (1, 6, 'admin');
INSERT INTO `user_role` VALUES (2, 19, 'default');
