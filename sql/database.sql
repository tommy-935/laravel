create database yourdb default character set utf8mb4 collate utf8mb4_unicode_ci;
use yourdb;
/*
create table tb_users (
    id int(11) auto_increment not null,
    `name` varchar(100) not null default "",
    `password` varchar(255) not null default "",
    `role` tinyint(1) not null default 0 comment "1. admin",
    `added_by` int(11) not null default 0,
    `added_date` datetime default null,
    primary key(id),
    key name_key (`name`)
)ENGINE=InnoDB;
insert into tb_user (id, `name`, `password`, role, added_by, added_date) values (1, "admin", "123456", 1, 0, "2025-03-23 00:00:00");
*/

drop table if exists tb_visits;
create table tb_visits (
    id int(11) auto_increment not null,
	session_id varchar(255) not null default "",
    ip varchar(255) not null default "",
    user_agent varchar(1000) not null default "",
    `url` varchar(1000) not null default "",
  `created_at` timestamp default NULL,
  `updated_at` timestamp default NULL,

    primary key(id),
	unique key sess_url (session_id, url)
)ENGINE=InnoDB;

drop table if exists tb_attachment;
create table tb_attachment(
	id int(11) not null auto_increment,
	`name` varchar(120) not null default "",
	`uri` varchar(255) not null default "",
	`type` varchar(10) not null default "image" comment "image/pdf/doc...",

	created_by int(11) not null default 0,
	updated_by int(11) not null default 0,
	`created_at` timestamp default NULL,
  	`updated_at` timestamp default NULL,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_attachment";

drop table if exists tb_cart_items;
create table tb_cart_items(
	id int(11) not null auto_increment,
	session_id varchar(125) not null default "",
	user_id int(11) not null default 0,
	item_key varchar(125) not null default "",
	product_id int(11) not null default 0,
	quantity int(11) not null default 0,
	expired_date datetime default null,
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_cart_items";

drop table if exists tb_cate_rela;
create table tb_cate_rela(
	id int(11) not null auto_increment,
	cate_id int(11) not null default 0,
	parent_id int(11) not null default 0,
	
	primary key(id),
	unique key(cate_id, parent_id)
)ENGINE=INNODB default charset=utf8mb4 comment "cate relation";

drop table if exists tb_cate;
create table tb_cate(
	id int(11) not null auto_increment,
	cate_name varchar(60) not null default "",
	slug varchar(60) not null default "",
	img_uri varchar(60) not null default "",
	`desc` varchar(800) not null default "",
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id),
	unique key(slug)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate";

# tb_menu_item
drop table if exists tb_menu_item;
create table tb_menu_item(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	url varchar(800) not null default "",

	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "menu item";

# tb_menu
drop table if exists tb_menu;
create table tb_menu(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	menu text default null,

	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id),
	unique key(`name`)
)ENGINE=INNODB default charset=utf8mb4 comment "menu";

# 
drop table if exists tb_order_price;
create table tb_order_price(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	`sub_total` varchar(6) not null default "",
	`discount_price` varchar(6) not null default "",
	`total` varchar(6) not null default "",
	`tax` varchar(6) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_order_price";

# 
drop table if exists tb_order_product;
create table tb_order_product(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	product_id int(11) not null default 0,
	`product_name` varchar(120) not null default "",
	`price` varchar(6) not null default "",
	qty int(11) not null default 0,
	`item_price` varchar(6) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_order_product";

# 
drop table if exists tb_order_user;
create table tb_order_user(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	user_id int(11) not null default 0,
	`session_id` varchar(60) not null default "",
	`billing_country` varchar(60) not null default "",
	`billing_state` varchar(25) not null default "",
	`billing_city` varchar(25) not null default "",
	`billing_first_name` varchar(25) not null default "",
	`billing_last_name` varchar(25) not null default "",
	`billing_email` varchar(60) not null default "",
	`billing_address1` varchar(255) not null default "",
	`billing_address2` varchar(255) not null default "",
	`billing_phone` varchar(25) not null default "",
	`billing_zip_code` varchar(25) not null default "",

	`shipping_country` varchar(60) not null default "",
	`shipping_state` varchar(25) not null default "",
	`shipping_city` varchar(25) not null default "",
	`shipping_first_name` varchar(25) not null default "",
	`shipping_last_name` varchar(25) not null default "",
	`shipping_email` varchar(60) not null default "",
	`shipping_address1` varchar(255) not null default "",
	`shipping_address2` varchar(255) not null default "",
	`shipping_phone` varchar(25) not null default "",
	`shipping_zip_code` varchar(25) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_order_user";

# 
drop table if exists tb_order;
create table tb_order(
	id int(11) not null auto_increment,
	`order_num` varchar(25) not null default "",
	`order_key` varchar(32) not null default "",
	`status` varchar(12) not null default '' comment "1.pending 2.processing 3. completed 4. failed 5. canceled 6. refunded",
	
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_order";

drop table if exists tb_order_payment;
create table tb_order_payment(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	`paid_date` datetime default null,
	`payment_method` varchar(12) not null default "" comment "wechatpay | alipay | paypal | stripe",
	`status` varchar(12) not null default '' comment "payment status",
	`amount` varchar(6) not null default "",
	`currency` varchar(6) not null default "USD",
	`transaction_id` varchar(255) not null default "",
	`details` text default null,
	
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_order_payment";



# 
drop table if exists tb_page;
create table tb_page(
	id int(11) not null auto_increment,
	`title` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	`content` longtext default null,
	
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id),
	unique key(uri)
)ENGINE=INNODB default charset=utf8mb4 comment "page";

# 
drop table if exists tb_product_cate_rela;
create table tb_product_cate_rela(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	cate_id int(11) not null default 0,
	
	
	primary key(id),
	unique key(product_id, cate_id)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate relation";

INSERT INTO  `tb_product_cate_rela`(`id`, `product_id`, `cate_id`) VALUES (1, 1, 1);

# 
drop table if exists tb_product_detail;
create table tb_product_detail(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	`price` varchar(10) not null default "",
	`short_desc` varchar(500) not null default "",
	`long_desc` text default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_product_detail";

INSERT INTO  `tb_product_detail`(`id`, `product_id`, `price`, `short_desc`, `long_desc`) VALUES (1, 1, '66', '6666666', 'dddddddddd');

# 
drop table if exists tb_product_img;
create table tb_product_img(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	attachment_id int(11) not null default 0,
	sort tinyint(1) not null default 0,
	is_main tinyint(1) not null default 0,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment  "tb_product_img";

# 
drop table if exists tb_product;
create table tb_product(
	id int(11) not null auto_increment,
	`name` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "product";


# tb_roles
drop table if exists tb_roles;
create table tb_roles(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id),
	unique key(`name`)
)ENGINE=INNODB default charset=utf8mb4 comment "role";

insert into tb_roles (name, created_at) values ("administrator", "2023-07-05 12:12:12");
insert into tb_roles (name, created_at) values ("customer", "2023-07-05 12:12:12");

# tb_user_roles
drop table if exists tb_user_roles;
create table tb_user_roles(
	id int(11) not null auto_increment,
	user_id int(11) not null default 0,
	role_id int(11) not null default 0,
	
	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id),
	unique key(user_id, role_id)
)ENGINE=INNODB default charset=utf8mb4 comment "user role";

insert into tb_user_role (user_id, role_id, added_date) values (1, 1, "2023-07-05 12:12:12");


drop table if exists tb_soft_token;
create table tb_soft_token(
	id int(11) not null auto_increment,
	`user_id` int(11) not null default 0,
	`email` varchar(60) not null default "",
	`token` varchar(60) not null default "",
	`order_id` int(11) not null default 0,
	`soft_name` varchar(60) not null default "",
	`website_num` int(11) not null default 1,
	`expired_at` datetime default null,

	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "tb_soft_token";

drop table if exists tb_soft_token_active;
create table tb_soft_token_active(
	id int(11) not null auto_increment,
	`soft_token_id` int(11) not null default 0,
	`website` varchar(60) not null default "",
	`actived_at` datetime default null,
	`ip` varchar(60) not null default "",
	`user_agent` varchar(255) not null default "",

	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "tb_soft_token_active";

drop table if exists tb_email_logs;
create table tb_email_logs(
	id int(11) not null auto_increment,
	`email` varchar(60) not null default "",
	`subject` varchar(800) not null default "",
	`body` text default null,
	`status` tinyint(1) not null default 1 comment "0: waitting, 1: success",

	created_by int(11) not null default 0,
	created_at datetime default null,
	updated_by int(11) not null default 0,
	updated_at datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "tb_email_logs";
