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