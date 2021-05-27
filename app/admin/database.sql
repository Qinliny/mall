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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;