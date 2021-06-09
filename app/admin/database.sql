# 商品分类表
CREATE TABLE `qinly_goods_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `category_name` varchar(15) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `sort` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#角色表
CREATE TABLE `qinly_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID 主键',
  `role_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#菜单表
CREATE TABLE `qinly_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单的名称',
  `parent_menu` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `menu_adds` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单地址',
  `menu_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `sort` int(5) NOT NULL COMMENT '地址',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#管理员信息表
CREATE TABLE `qinly_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admins_name` varchar(30) NOT NULL COMMENT '管理员姓名',
  `phone` char(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '电子邮箱',
  `wx_number` varchar(20) DEFAULT NULL COMMENT '微信号',
  `qq_number` varchar(15) DEFAULT NULL COMMENT 'qq号',
  `native_place` varchar(70) NOT NULL DEFAULT '' COMMENT '籍贯信息',
  `birthday` date NOT NULL COMMENT '出生年月日',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别 0女 1男',
  `password` char(60) NOT NULL COMMENT '登录密码',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0开启 1关闭',
  `create_time` datetime NOT NULL COMMENT '注册时间',
  `update_time` datetime NOT NULL COMMENT '修改信息时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
