/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : thinkp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-14 18:33:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_app_version
-- ----------------------------
DROP TABLE IF EXISTS `tp_app_version`;
CREATE TABLE `tp_app_version` (
  `id` int(20) NOT NULL,
  `app_type` varchar(20) DEFAULT NULL COMMENT 'APP类型ios andriod',
  `version` int(8) DEFAULT '0' COMMENT '内部版本号',
  `version_code` varchar(20) DEFAULT NULL COMMENT '外部版本号',
  `is_force` tinyint(1) DEFAULT '0' COMMENT '是否强制更新 0不 1是',
  `apk_url` varchar(255) DEFAULT NULL COMMENT 'apk包版本地址',
  `upgrade_point` varchar(500) DEFAULT NULL COMMENT '升级提示',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `creat_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='app版本表';

-- ----------------------------
-- Records of tp_app_version
-- ----------------------------
INSERT INTO `tp_app_version` VALUES ('1', 'adroid', '1', '1.1', '1', 'www.xxxx.com', '1.优化了。。2.增加了。。。3减少了。。', '1', '2019-08-14 17:56:45', '2019-08-14 17:56:48');
