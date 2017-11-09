create database if not exists jxshop;
use jxshop;
set names utf8;
drop table if exists jxshop_goods;
create table jxshop_goods
(
	 id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	 logo varchar(150) not null default '' comment 'logo',
	 sm_logo varchar(150) not null default '' comment '小的缩略图',
	 mid_logo varchar(150) not null default '' comment '中的缩略图',
	 cat_id mediumint unsigned not null comment '主分类id',
	 addtime int unsigned not null comment '创建的时间',
	 is_on_sale enum('是','否') not null default '是' comment '是否上架',
	 goods_desc longtext comment '商品的描述',
	 primary key (id),
	 key shop_price(shop_price),
	 key addtime(addtime),
	 key is_on_sale(is_on_sale),
	 key cat_id(cat_id)
)engine=myisam default charset=utf8 comment '商品';

create table jxshop_category
(
 id SMALLINT unsigned not null auto_increment comment 'id',
 cate_name varchar(150) not null comment '分类名称',
 parent_id SMALLINT  unsigned not null default '0' comment '上一级id',
 primary key(id)
)engine=myisam DEFAULT charset=utf8 comment '分类表';

create table jxshop_goods_cat
(
 goods_id mediumint unsigned not null comment '商品id',
 cat_id SMALLINT  unsigned not null comment '拓展分类id',
 key goods_id(goods_id),
 key cat_id(cat_id)
)engine=myisam default charset=utf8 comment '拓展分类表'

create table jxshop_admin
(
 id mediumint unsigned not null auto_increment comment 'id',
 username VARCHAR(30) not null comment '账号',
 password CHAR(32) not null comment '密码',
 PRIMARY KEY (id),
 key(username)
)engine=myisam default charset=utf8 comment '管理员表'

create table jxshop_privilege
(
 id mediumint unsigned not null  auto_increment comment 'id',
 pri_name mediumint unsigned not null comment '权限名称',
	modile_name VARCHAR(60) not null comment '模块名',
	controller_name VARCHAR(60) not null comment '控制器名',
 	action_name varchar(60) not null comment '方法名',
	parent_id MEDIUMINT UNSIGNED NOT NULL  comment '上一级权限',
	PRIMARY KEY (id)
)engine=myisam default charset=utf8 comment '权限表'

	create table jxshop_pri_role
	(
		role_id MEDIUMINT UNSIGNED NOT NULL  comment '角色id',
		pri_id MEDIUMINT UNSIGNED NOT NULL  COMMENT  '权限id',
		key role_id(role_id),
		key pri_id(pri_id)
	)engine=myisam default charset=utf8 comment '角色权限表'

	create table jxshop_role
	(
    id MEDIUMINT UNSIGNED NOT NULL auto_increment COMMENT  'id',
		role_name VARCHAR(30) not null COMMENT  '角色名',
		PRIMARY KEY (id)
	)ENGINE=myisam DEFAULT charset=utf8 comment '角色表'

	create table jxshop_admin_role
	(
		admin_id  MEDIUMINT UNSIGNED not NULL  comment '管理员id',
		role_id MEDIUMINT UNSIGNED NOT NULL  COMMENT  '角色id',
		KEY (admin_id),
		KEY (role_id)
	)ENGINE=myisam DEFAULT  CHARSET=utf8 comment '角色管理原表'

create table jxshop_type
(
	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT  comment '类型id',
	type_name VARCHAR(60)  NOT NULL  COMMENT  '类型名',
	PRIMARY KEY id(id)
)engine=myisam default charset=utf8 comment '类型表'

create table jxshop_attribute
(
	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT  comment '角色id',
	attr_name VARCHAR(60)  NOT NULL  COMMENT  '属性名',
	attr_type ENUM('可选','唯一') NOT NULL DEFAULT '唯一' comment '属性类型',
	attr_type_value VARCHAR(120) NOT NULL DEFAULT '' COMMENT  '可选的值',
	type_id SMALLINT UNSIGNED NOT NULL comment '类型id',
  key  (type_id),
	PRIMARY KEY id(id)
)engine=myisam default charset=utf8 comment '属性表'

	create table jxshop_goods_attr
	(
		id MEDIUMINT unsigned not null  comment '商品id',
		attr_id mediumint not null comment '属性id',
		attr_value VARCHAR(120) not null DEFAULT '' comment '属性值',
		key (attr_id),
		key(attr_value),
		key(id)
	)engine=myisam DEFAULT charset=utf8 COMMENT '商品值表'

