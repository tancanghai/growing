/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : thinkp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-17 00:41:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_app_uer
-- ----------------------------
DROP TABLE IF EXISTS `tp_app_uer`;
CREATE TABLE `tp_app_uer` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `signature` varchar(100) DEFAULT NULL COMMENT '个性签名',
  `time_out` int(10) DEFAULT NULL COMMENT 'token失效时间',
  `image` varchar(100) DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='App用户表';

-- ----------------------------
-- Records of tp_app_uer
-- ----------------------------
