/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50728
Source Host           : 192.168.119.128:3306
Source Database       : think.book.com

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-06-04 00:03:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bk_admins
-- ----------------------------
DROP TABLE IF EXISTS `bk_admins`;
CREATE TABLE `bk_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `idx_username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_admins
-- ----------------------------
INSERT INTO `bk_admins` VALUES ('1', 'admin', '$2y$10$7dR5osAd5/U1mowcNCloY.pdlaC3dx0phqA4dbwOboBqHOBRy45/S', '2020-04-27 17:11:37', '2020-04-29 17:30:14');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
  `vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：非vip；1：月卡；2：季卡；3：年卡',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '借阅余额',
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
-- Table structure for bk_class_vips
-- ----------------------------
DROP TABLE IF EXISTS `bk_class_vips`;
CREATE TABLE `bk_class_vips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `unionid` varchar(32) DEFAULT NULL,
  `vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：非vip；1：vip',
  `balance` int(10) NOT NULL DEFAULT '0' COMMENT '课时余额',
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
-- Table structure for bk_users
-- ----------------------------
DROP TABLE IF EXISTS `bk_users`;
CREATE TABLE `bk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT NULL COMMENT '小程序用户的openid',
  `unionid` varchar(32) DEFAULT NULL,
  `nickname` varchar(128) DEFAULT NULL COMMENT '用户头像',
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bk_videos
-- ----------------------------
INSERT INTO `bk_videos` VALUES ('5', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '1', '1', '2020-06-02 20:59:26', '2020-06-02 20:59:26');
INSERT INTO `bk_videos` VALUES ('6', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '0', '1', '2020-06-03 23:59:25', '2020-06-03 23:59:25');
INSERT INTO `bk_videos` VALUES ('7', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '0', '1', '2020-06-03 23:59:26', '2020-06-03 23:59:26');
INSERT INTO `bk_videos` VALUES ('8', 'ceshi', '测试股氨基酸看到', '/static/uploads/video/20200601/89e892e7c0152c2982fb569f6b22a094.mp4', '1', '1', '2020-06-03 23:59:27', '2020-06-03 23:59:27');
