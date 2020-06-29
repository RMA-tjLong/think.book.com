/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50728
Source Host           : 192.168.119.128:3306
Source Database       : think.book.com

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-06-29 22:09:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bk_activities
-- ----------------------------
DROP TABLE IF EXISTS `bk_activities`;
CREATE TABLE `bk_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `content` text,
  `adminid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `kind` tinyint(1) DEFAULT '1' COMMENT '1：精品活动；2：商业活动',
  `status` tinyint(1) DEFAULT '1' COMMENT '0：已删除；1：已下架；2：上架中；',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_activities
-- ----------------------------
INSERT INTO `bk_activities` VALUES ('1', 'sdasda', 'asldjkjhasj', '1', '213asdsdasd', '1', '1', '2020-06-09 21:12:52', '2020-06-09 21:20:20');
INSERT INTO `bk_activities` VALUES ('2', 'ceshi', '测试股氨基酸看到', '1', '/static/uploads/image/20200609/e77c477218c900132fd09b8b3eb40d33.png', '2', '2', '2020-06-10 20:12:16', '2020-06-10 20:12:16');

-- ----------------------------
-- Table structure for bk_admins
-- ----------------------------
DROP TABLE IF EXISTS `bk_admins`;
CREATE TABLE `bk_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(16) DEFAULT NULL,
  `groupid` int(11) DEFAULT NULL COMMENT '组id，一个组可能包含多个角色',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `idx_username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_admins
-- ----------------------------
INSERT INTO `bk_admins` VALUES ('1', 'admin', '70a0e2fe119d7baa81d2f8cab65245ac', 'y67ufX', '1', '2020-04-27 17:11:37', '2020-04-29 17:30:14');

-- ----------------------------
-- Table structure for bk_ads
-- ----------------------------
DROP TABLE IF EXISTS `bk_ads`;
CREATE TABLE `bk_ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL COMMENT '图片链接',
  `adminid` int(11) DEFAULT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_ads
-- ----------------------------
INSERT INTO `bk_ads` VALUES ('6', '图片1', '测试', '/static/uploads/image/20200531/11bfd5415d095db38a3a5a1a1fd7bc3f.png', '1', '2020-06-03 22:04:52', '2020-06-03 22:04:52');
INSERT INTO `bk_ads` VALUES ('7', '图片1', 'sjlkajsdl', 'asdasdasd', '1', '2020-06-03 22:04:58', '2020-06-03 22:06:14');
INSERT INTO `bk_ads` VALUES ('8', '图片1', '测试', '/static/uploads/image/20200531/11bfd5415d095db38a3a5a1a1fd7bc3f.png', '1', '2020-06-03 23:17:26', '2020-06-03 23:17:26');
INSERT INTO `bk_ads` VALUES ('10', '图片1', '测试', '/static/uploads/image/20200531/11bfd5415d095db38a3a5a1a1fd7bc3f.png', '1', '2020-06-03 23:17:27', '2020-06-03 23:17:27');

-- ----------------------------
-- Table structure for bk_book_vips
-- ----------------------------
DROP TABLE IF EXISTS `bk_book_vips`;
CREATE TABLE `bk_book_vips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `unionid` varchar(32) DEFAULT NULL,
  `vip` tinyint(1) DEFAULT '0' COMMENT '0：非vip；1：月卡；2：季卡；3：年卡',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '借阅余额',
  `ended_at` date DEFAULT NULL COMMENT 'vip到期时间',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unionid` (`unionid`) USING BTREE,
  UNIQUE KEY `idx_userid` (`userid`) USING BTREE,
  CONSTRAINT `fk_users_book_vips_on_id` FOREIGN KEY (`userid`) REFERENCES `bk_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_book_vips
-- ----------------------------
INSERT INTO `bk_book_vips` VALUES ('1', '1', '1234567', '3', '0.10', '2020-06-02', '2020-04-29 17:40:04', '2020-06-03 23:53:44');
INSERT INTO `bk_book_vips` VALUES ('2', '2', '42343', '1', '12.33', '2020-06-01', '2020-04-29 19:51:20', '2020-05-27 00:10:15');
INSERT INTO `bk_book_vips` VALUES ('3', '3', 'qweqwe', '1', '1233213.00', null, '2020-05-25 22:07:12', '2020-05-25 22:07:15');

-- ----------------------------
-- Table structure for bk_books
-- ----------------------------
DROP TABLE IF EXISTS `bk_books`;
CREATE TABLE `bk_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL COMMENT '图书名称',
  `number` varchar(16) DEFAULT NULL COMMENT '编号',
  `num` int(8) DEFAULT '1' COMMENT '总册数',
  `barcode` varchar(16) DEFAULT NULL COMMENT '书刊条码',
  `isbn` varchar(16) DEFAULT NULL COMMENT 'ISBN',
  `author` varchar(64) DEFAULT NULL COMMENT '作者',
  `publishing` varchar(128) DEFAULT NULL COMMENT '出版社',
  `cover` varchar(255) DEFAULT NULL COMMENT '封面',
  `price` decimal(10,2) DEFAULT NULL COMMENT '总值',
  `description` text COMMENT '描述',
  `content` text COMMENT '内容简介 ',
  `collection` varchar(16) DEFAULT NULL COMMENT '馆藏',
  `room` varchar(16) DEFAULT NULL COMMENT '所在书室',
  `shelf` varchar(16) DEFAULT NULL COMMENT '书架',
  `generationid` tinyint(1) DEFAULT NULL COMMENT '年龄段id',
  `taskid` int(11) DEFAULT NULL COMMENT '上传批次id',
  `adminid` int(11) DEFAULT NULL COMMENT '管理员id',
  `status` tinyint(1) DEFAULT '1' COMMENT '0：已删除；1：已下架；2：上架中；',
  `uploaded_at` datetime DEFAULT NULL COMMENT '上架时间',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_books
-- ----------------------------
INSERT INTO `bk_books` VALUES ('2', '揭秘小世界（森林）', '168800192', '1', '9787541765339', '7541765333', '张双叶', '', '/static/files/book-default-cover.png', '49.80', null, '', '1', '2', '', null, '4', '1', '0', null, '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('3', '揭秘小世界（四季）', '168800191', '1', '9787541765230', '7541765236', '权慧娟', '', '/static/files/book-default-cover.png', '49.80', null, '', '1', '2', '', '3', '4', '1', '2', '2020-06-29 21:23:07', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('4', '汽车多多多！', '168800004', '1', '9787505632639', '7505632639', '石哲元', '', '/static/files/book-default-cover.png', '29.80', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('6', '爸爸出门以后......', '168800303', '1', '9787549584482', '7549584486', '伊莎贝尔', '', '/static/files/book-default-cover.png', '34.80', null, '', '1', '2', '', '3', '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('7', '影子飞机', '168800213', '1', '9787533289843', '7533289846', '五味太郎', '', '/static/files/book-default-cover.png', '33.80', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('8', '揭秘丛林', '168800186', '1', '9787545065770', '7545065778', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('10', '揭秘夜晚', '168800187', '1', '9787545065787', '7545065786', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('11', '揭秘动物', '168800188', '1', '9787545068993', '7545068998', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('12', '早识300字', '168800204', '1', '9787538623857', '753862385x', '赵国强', '', '/static/files/book-default-cover.png', '13.90', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('13', '大字百家姓', '168800203', '1', '9787538640830', '7538640835', '赵国强', '', '/static/files/book-default-cover.png', '13.90', null, '', '1', '2', '', null, '4', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_books` VALUES ('14', '揭秘小世界（城市）', '168800185', '1', '9787541765247', '7541765244', '张双', '', '/static/files/book-default-cover.png', '49.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('15', '揭秘小世界（森林）', '168800192', '1', '9787541765339', '7541765333', '张双叶', '', '/static/files/book-default-cover.png', '49.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('16', '揭秘小世界（四季）', '168800191', '1', '9787541765230', '7541765236', '权慧娟', '', '/static/files/book-default-cover.png', '49.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('17', '汽车多多多！', '168800004', '1', '9787505632639', '7505632639', '石哲元', '', '/static/files/book-default-cover.png', '29.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('18', '五颜六色的公交车', '168800297', '1', '9787559618917', '755961891x', 'tupera tupera', '', '/static/files/book-default-cover.png', '34.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('19', '爸爸出门以后......', '168800303', '1', '9787549584482', '7549584486', '伊莎贝尔', '', '/static/files/book-default-cover.png', '34.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('20', '影子飞机', '168800213', '1', '9787533289843', '7533289846', '五味太郎', '', '/static/files/book-default-cover.png', '33.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('21', '揭秘丛林', '168800186', '1', '9787545065770', '7545065778', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('22', '揭秘自然', '168800190', '1', '9787545068986', '754506898x', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('23', '揭秘夜晚', '168800187', '1', '9787545065787', '7545065786', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('24', '揭秘动物', '168800188', '1', '9787545068993', '7545068998', '保罗·维尔', '', '/static/files/book-default-cover.png', '68.80', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('25', '早识300字', '168800204', '1', '9787538623857', '753862385x', '赵国强', '', '/static/files/book-default-cover.png', '13.90', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('26', '大字百家姓', '168800203', '1', '9787538640830', '7538640835', '赵国强', '', '/static/files/book-default-cover.png', '13.90', null, '', '1', '2', '', null, '5', '1', '2', '2020-06-29 21:23:49', '2020-06-27 21:58:43', '2020-06-27 21:58:43');
INSERT INTO `bk_books` VALUES ('27', '2313', 'uywyiqwe', '1', '123123', null, null, null, 'asdasdasd', null, null, 'sjlkajsdl', null, null, null, null, null, '1', '2', '2020-06-28 21:33:32', '2020-06-28 21:18:27', '2020-06-28 21:33:32');
INSERT INTO `bk_books` VALUES ('28', '2313', '123123123', '1', '12312asd', null, null, null, '/static/files/book-default-cover.png', null, null, null, null, null, null, null, null, '1', '1', null, '2020-06-29 21:34:30', '2020-06-29 21:34:30');
INSERT INTO `bk_books` VALUES ('29', '2313', '123123123', '1', '12312asd', null, null, null, '/static/files/book-default-cover.png', null, null, null, null, null, null, null, null, '1', '1', null, '2020-06-29 21:34:43', '2020-06-29 21:34:43');

-- ----------------------------
-- Table structure for bk_class_vips
-- ----------------------------
DROP TABLE IF EXISTS `bk_class_vips`;
CREATE TABLE `bk_class_vips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `unionid` varchar(32) DEFAULT NULL,
  `vip` tinyint(1) DEFAULT '0' COMMENT '0：非vip；1：vip',
  `balance` int(10) DEFAULT '0' COMMENT '课时余额',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unionid` (`unionid`) USING BTREE,
  UNIQUE KEY `idx_userid` (`userid`) USING BTREE,
  CONSTRAINT `fk_users_class_vips_on_id` FOREIGN KEY (`userid`) REFERENCES `bk_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_class_vips
-- ----------------------------
INSERT INTO `bk_class_vips` VALUES ('1', '1', '1312', '1', '12', '2020-05-26 23:23:10', '2020-06-03 23:54:05');

-- ----------------------------
-- Table structure for bk_formal_courses
-- ----------------------------
DROP TABLE IF EXISTS `bk_formal_courses`;
CREATE TABLE `bk_formal_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0：已删除；1：已下架；2：上架中；',
  `adminid` int(11) DEFAULT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_formal_courses
-- ----------------------------
INSERT INTO `bk_formal_courses` VALUES ('2', '3123大大', '试听课内容', '2', '1', '2020-06-07 21:32:49', '2020-06-07 22:26:50');
INSERT INTO `bk_formal_courses` VALUES ('4', '试听课', '试听课内容', '1', '1', '2020-06-07 21:32:49', '2020-06-07 21:32:52');
INSERT INTO `bk_formal_courses` VALUES ('7', 'ahjskdh', null, '1', '1', '2020-06-07 21:44:29', '2020-06-07 21:44:29');
INSERT INTO `bk_formal_courses` VALUES ('8', 'ahjskdh', null, '1', '1', '2020-06-07 21:44:42', '2020-06-07 21:44:42');
INSERT INTO `bk_formal_courses` VALUES ('9', 'ahjskdh', 'sjflksjflkdsfsdf', '1', '1', '2020-06-07 21:44:52', '2020-06-07 21:44:52');
INSERT INTO `bk_formal_courses` VALUES ('10', 'ahjskdh', 'sjflksjflkdsfsdf', '2', '1', '2020-06-07 21:45:09', '2020-06-07 21:45:09');
INSERT INTO `bk_formal_courses` VALUES ('11', 'ahjskdh', 'sjflksjflkdsfsdf', '2', '1', '2020-06-07 22:27:15', '2020-06-07 22:27:15');

-- ----------------------------
-- Table structure for bk_generations
-- ----------------------------
DROP TABLE IF EXISTS `bk_generations`;
CREATE TABLE `bk_generations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT '年龄段内容',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_generations
-- ----------------------------
INSERT INTO `bk_generations` VALUES ('2', '2313', '2020-06-29 22:00:11', '2020-06-29 22:01:42');

-- ----------------------------
-- Table structure for bk_groups
-- ----------------------------
DROP TABLE IF EXISTS `bk_groups`;
CREATE TABLE `bk_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '分组父id，0表示该组没有父级',
  `name` varchar(32) DEFAULT NULL COMMENT '组名',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_groups
-- ----------------------------
INSERT INTO `bk_groups` VALUES ('1', '0', '超级管理员', '2020-06-07 21:01:32', '2020-06-07 21:01:36');

-- ----------------------------
-- Table structure for bk_groups_permissions
-- ----------------------------
DROP TABLE IF EXISTS `bk_groups_permissions`;
CREATE TABLE `bk_groups_permissions` (
  `groupid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_groups_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for bk_info
-- ----------------------------
DROP TABLE IF EXISTS `bk_info`;
CREATE TABLE `bk_info` (
  `id` int(1) NOT NULL,
  `name` varchar(32) DEFAULT NULL COMMENT '企业名称',
  `lat` decimal(16,6) DEFAULT NULL,
  `lng` decimal(16,6) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `company_culture` text,
  `curriculum_structure` text,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_info
-- ----------------------------
INSERT INTO `bk_info` VALUES ('1', '2', '12312.123340', '7318.213231', 'asdjkhkaj啊是多久啊客户机', '7812313', '阿斯顿', '7', '2020-06-08 21:52:03');

-- ----------------------------
-- Table structure for bk_permissions
-- ----------------------------
DROP TABLE IF EXISTS `bk_permissions`;
CREATE TABLE `bk_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(128) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `i_menu` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for bk_tasks
-- ----------------------------
DROP TABLE IF EXISTS `bk_tasks`;
CREATE TABLE `bk_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_tasks
-- ----------------------------
INSERT INTO `bk_tasks` VALUES ('4', '123', '2020-06-27 21:34:17', '2020-06-27 21:34:17');
INSERT INTO `bk_tasks` VALUES ('5', '123', '2020-06-27 21:58:43', '2020-06-27 21:58:43');

-- ----------------------------
-- Table structure for bk_trial_courses
-- ----------------------------
DROP TABLE IF EXISTS `bk_trial_courses`;
CREATE TABLE `bk_trial_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL COMMENT '试听课名称',
  `content` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0：已删除；1：已下架；2：上架中；',
  `adminid` int(11) DEFAULT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_trial_courses
-- ----------------------------
INSERT INTO `bk_trial_courses` VALUES ('2', '3123', '试听课内容', '1', '1', '2020-06-07 21:32:49', '2020-06-07 22:16:21');
INSERT INTO `bk_trial_courses` VALUES ('4', '试听课', '试听课内容', '1', '1', '2020-06-07 21:32:49', '2020-06-07 21:32:52');
INSERT INTO `bk_trial_courses` VALUES ('5', '试听课', '试听课内容', '1', '1', '2020-06-07 21:32:49', '2020-06-07 21:32:52');
INSERT INTO `bk_trial_courses` VALUES ('6', '试听课', '试听课内容', '1', '1', '2020-06-07 21:32:49', '2020-06-07 21:32:52');
INSERT INTO `bk_trial_courses` VALUES ('7', 'ahjskdh', null, '1', '1', '2020-06-07 21:44:29', '2020-06-07 21:44:29');
INSERT INTO `bk_trial_courses` VALUES ('8', 'ahjskdh', null, '1', '1', '2020-06-07 21:44:42', '2020-06-07 21:44:42');
INSERT INTO `bk_trial_courses` VALUES ('9', 'ahjskdh', 'sjflksjflkdsfsdf', '1', '1', '2020-06-07 21:44:52', '2020-06-07 21:44:52');
INSERT INTO `bk_trial_courses` VALUES ('10', 'ahjskdh', 'sjflksjflkdsfsdf', '2', '1', '2020-06-07 21:45:09', '2020-06-07 21:45:09');

-- ----------------------------
-- Table structure for bk_users
-- ----------------------------
DROP TABLE IF EXISTS `bk_users`;
CREATE TABLE `bk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT NULL COMMENT '小程序用户的openid',
  `unionid` varchar(32) DEFAULT NULL,
  `nickname` varchar(128) DEFAULT NULL COMMENT '用户昵称',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `avatar_url` varchar(128) DEFAULT NULL COMMENT '用户头像',
  `gender` tinyint(1) DEFAULT NULL COMMENT '性别  0-男、1-女',
  `country` varchar(128) DEFAULT NULL COMMENT '所在国家',
  `province` varchar(128) DEFAULT NULL COMMENT '省份',
  `city` varchar(128) DEFAULT NULL COMMENT '城市',
  `language` varchar(128) DEFAULT NULL COMMENT '语种',
  `phone` varchar(32) DEFAULT NULL COMMENT '手机号码',
  `signature` varchar(255) DEFAULT NULL COMMENT '签名',
  `i_teacher` tinyint(1) DEFAULT '0' COMMENT '是否是教师',
  `added_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `unionid` (`unionid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='小程序用户表';

-- ----------------------------
-- Records of bk_users
-- ----------------------------
INSERT INTO `bk_users` VALUES ('1', '1234567', '1234567', '测试', null, null, null, null, null, null, null, null, null, '0', '2020-04-29 17:40:19', '2020-06-03 23:54:21');
INSERT INTO `bk_users` VALUES ('2', '112233', '12313', 'asdasd', null, null, null, null, null, null, null, null, null, '0', '2020-04-29 19:51:20', '2020-04-29 19:51:20');
INSERT INTO `bk_users` VALUES ('3', 'asdqweqwe', 'qwe213123', 'sdsda', null, null, null, null, null, null, null, null, null, '0', '2020-05-25 22:06:39', '2020-05-25 22:06:44');

-- ----------------------------
-- Table structure for bk_videos
-- ----------------------------
DROP TABLE IF EXISTS `bk_videos`;
CREATE TABLE `bk_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0：已删除；1：已下架；2：上架中；',
  `adminid` int(11) DEFAULT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_videos
-- ----------------------------
INSERT INTO `bk_videos` VALUES ('5', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '1', '1', '2020-06-02 20:59:26', '2020-06-02 20:59:26');
INSERT INTO `bk_videos` VALUES ('6', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '0', '1', '2020-06-03 23:59:25', '2020-06-03 23:59:25');
INSERT INTO `bk_videos` VALUES ('7', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '0', '1', '2020-06-03 23:59:26', '2020-06-03 23:59:26');
INSERT INTO `bk_videos` VALUES ('8', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '1', '1', '2020-06-03 23:59:27', '2020-06-03 23:59:27');
