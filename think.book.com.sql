/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50728
Source Host           : 192.168.119.128:3306
Source Database       : think.book.com

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-05-01 21:52:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for book_admins
-- ----------------------------
DROP TABLE IF EXISTS `book_admins`;
CREATE TABLE `book_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `idx_username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_admins
-- ----------------------------
INSERT INTO `book_admins` VALUES ('1', 'admin', '$2y$10$7dR5osAd5/U1mowcNCloY.pdlaC3dx0phqA4dbwOboBqHOBRy45/S', '2020-04-27 17:11:37', '2020-04-29 17:30:14');

-- ----------------------------
-- Table structure for book_users
-- ----------------------------
DROP TABLE IF EXISTS `book_users`;
CREATE TABLE `book_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT NULL COMMENT '小程序用户的openid',
  `unionid` varchar(32) DEFAULT NULL,
  `nickname` varchar(128) DEFAULT NULL COMMENT '用户头像',
  `avatar_url` varchar(128) DEFAULT NULL COMMENT '用户头像',
  `gender` tinyint(1) DEFAULT NULL COMMENT '性别  0-男、1-女',
  `country` varchar(128) DEFAULT NULL COMMENT '所在国家',
  `province` varchar(128) DEFAULT NULL COMMENT '省份',
  `city` varchar(128) DEFAULT NULL COMMENT '城市',
  `language` varchar(128) DEFAULT NULL COMMENT '语种',
  `phone` varchar(32) DEFAULT NULL COMMENT '手机号码',
  `signature` varchar(255) DEFAULT NULL COMMENT '签名',
  `added_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `unionid` (`unionid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='小程序用户表';

-- ----------------------------
-- Records of book_users
-- ----------------------------
INSERT INTO `book_users` VALUES ('1', '1234567', '1234567', '测试', null, null, null, null, null, null, null, null, '2020-04-29 17:40:19', '2020-04-29 17:40:21');
INSERT INTO `book_users` VALUES ('2', '112233', '12313', 'asdasd', null, null, null, null, null, null, null, null, '2020-04-29 19:51:20', '2020-04-29 19:51:20');

-- ----------------------------
-- Table structure for book_vips
-- ----------------------------
DROP TABLE IF EXISTS `book_vips`;
CREATE TABLE `book_vips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `unionid` varchar(32) DEFAULT NULL,
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `added_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unionid` (`unionid`) USING BTREE,
  UNIQUE KEY `idx_userid` (`userid`) USING BTREE,
  CONSTRAINT `fk_users_vips_on_id` FOREIGN KEY (`userid`) REFERENCES `book_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_vips
-- ----------------------------
INSERT INTO `book_vips` VALUES ('1', '1', '1234567', '1', '11.23', '2020-04-29 17:40:04', '2020-05-01 20:49:21');
INSERT INTO `book_vips` VALUES ('2', '2', '42343', '1', '36.33', '2020-04-29 19:51:20', '2020-05-01 21:28:47');
