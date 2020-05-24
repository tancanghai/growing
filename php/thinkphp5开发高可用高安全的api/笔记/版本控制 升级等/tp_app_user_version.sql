/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : thinkp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-14 18:33:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_app_user_version
-- ----------------------------
DROP TABLE IF EXISTS `tp_app_user_version`;
CREATE TABLE `tp_app_user_version` (
  `id` int(10) NOT NULL,
  `version` varchar(8) DEFAULT NULL,
  `app_type` varchar(20) DEFAULT NULL,
  `version_code` varchar(10) DEFAULT NULL,
  `did` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户版本信息  header携带过的信息  便于统计';

-- ----------------------------
-- Records of tp_app_user_version
-- ----------------------------
