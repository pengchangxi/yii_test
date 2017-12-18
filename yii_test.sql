/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yii_test

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-18 08:34:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for access
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类,请加应用前缀,如admin_',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE,
  CONSTRAINT `dx_rule_name` FOREIGN KEY (`rule_name`) REFERENCES `menu` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of access
-- ----------------------------
INSERT INTO `access` VALUES ('58', '2', 'xtgl', 'admin_url');
INSERT INTO `access` VALUES ('59', '2', '/menu/index', 'admin_url');
INSERT INTO `access` VALUES ('60', '2', '/menu/create', 'admin_url');
INSERT INTO `access` VALUES ('61', '2', '/menu/update', 'admin_url');
INSERT INTO `access` VALUES ('62', '2', '/sign/index', 'admin_url');
INSERT INTO `access` VALUES ('63', '2', 'glygl', 'admin_url');
INSERT INTO `access` VALUES ('64', '2', '/role/index', 'admin_url');
INSERT INTO `access` VALUES ('65', '2', '/role/create', 'admin_url');
INSERT INTO `access` VALUES ('66', '2', '/role/update', 'admin_url');
INSERT INTO `access` VALUES ('67', '2', '/admins/index', 'admin_url');
INSERT INTO `access` VALUES ('68', '2', '/admins/create', 'admin_url');
INSERT INTO `access` VALUES ('69', '2', '/admins/update', 'admin_url');

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '账户',
  `email` char(32) NOT NULL DEFAULT '',
  `mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '手机号',
  `realname` varchar(32) NOT NULL DEFAULT '',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `password_hash` varchar(64) NOT NULL,
  `auth_key` varchar(64) NOT NULL DEFAULT '' COMMENT '密码盐',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像地址',
  `created_at` int(10) NOT NULL DEFAULT '0',
  `updated_at` int(10) NOT NULL DEFAULT '0',
  `role_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '角色ID',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态  0  禁用  1 启用 默认 1 启用',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '上次登录IP',
  `last_login_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上次登录时间',
  `errornum` tinyint(2) NOT NULL DEFAULT '0' COMMENT '登录错误次数  固定时间内出错超过5次 就禁用户',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`username`) USING BTREE,
  KEY `realname` (`realname`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'admin@test.cn', '13225962308', '超级管理员', 'Super Admin', '$2y$13$0UVcG.mXF6Og0rnjfwJd2.wixT2gdn.wDO9rN44jGtIGc6JvBqR7i', 'SbSY36BLw3V2lU-GB7ZAzCVJKDFx82IJ', 'http://local.yiitest.com/uploads/img/2017070605074067918.jpg', '1510207061', '1510207061', '1', '1', '127.0.0.1', '2017-11-03 16:40:02', '0');
INSERT INTO `admins` VALUES ('2', 'test123', '1234355@qq.com', '13225962582', 'test123', 'test123', '$2y$13$cP8JuaPWEfbhng.CBi04wO4pl2oQJFk98uWQmlcNkoaiC/tCk6fHy', 'R4T4eDd8m1SCPGtqhckVR0IIWzjaVO3d', 'http://local.yiitest.com/uploads/img/2017070605074067918.jpg', '1510207061', '1510902638', '2', '1', '', '2017-05-17 10:42:48', '0');
INSERT INTO `admins` VALUES ('3', 'test', '5454@qq.com', '13225962990', 'fdf', 'fdfdf', '$2y$13$rGvB5PUUC3gZBRBJukzuzeCBTKBI/DbgZ09q58AQFbDkvkk7KEe36', '2oW_d8RhMuaONA-q_97cgW0adMgmYNmu', '', '1510902250', '1510903702', '2', '1', '', '2017-11-17 15:04:10', '0');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '文章标题',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `content` text COMMENT '文章内容',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1显示 0隐藏',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '也是奇怪', 'bro7yz.jpg', '<p><em><strong>费大幅度发的说法是</strong></em><br/></p>', '1509598958', '0', '1');
INSERT INTO `article` VALUES ('2', '反对方答复', 'qcv6hl.jpg', '地方大幅度发', '122', '0', '1');
INSERT INTO `article` VALUES ('3', '43434', 'c8djv2.jpg', '辅导辅导', '111', '0', '1');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是后台菜单',
  `islog` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否需要记录操作日志  1 是 0 否',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'xtgl', '系统管理', '', '1', '', '99', '0', '0', '1', '0');
INSERT INTO `menu` VALUES ('2', 'glygl', '管理员管理', '', '1', '', '99', '0', '0', '1', '0');
INSERT INTO `menu` VALUES ('5', '/menu/index', '菜单管理', '', '1', '', '99', '1', '1', '1', '0');
INSERT INTO `menu` VALUES ('6', '/role/index', '角色管理', '', '1', '', '99', '2', '1', '1', '0');
INSERT INTO `menu` VALUES ('7', '/admins/index', '管理员列表', '', '1', '', '99', '2', '1', '1', '0');
INSERT INTO `menu` VALUES ('8', '/menu/create', '添加', '', '1', '奇怪', '99', '5', '2', '0', '1');
INSERT INTO `menu` VALUES ('9', '/menu/update', '编辑', '', '1', '', '99', '5', '2', '0', '1');
INSERT INTO `menu` VALUES ('10', '/menu/delete', '删除', '', '1', '', '99', '5', '2', '0', '1');
INSERT INTO `menu` VALUES ('11', '/role/create', '添加', '', '1', '', '99', '6', '2', '0', '1');
INSERT INTO `menu` VALUES ('12', '/role/update', '编辑', '', '1', '', '99', '6', '2', '0', '1');
INSERT INTO `menu` VALUES ('13', '/role/delete', '删除', '', '1', '', '99', '6', '2', '0', '1');
INSERT INTO `menu` VALUES ('14', '/admins/create', '添加', '', '1', '', '99', '7', '2', '0', '1');
INSERT INTO `menu` VALUES ('16', '/admins/update', '编辑', '', '1', '', '99', '7', '2', '0', '1');
INSERT INTO `menu` VALUES ('17', '/admins/delete', '删除', '', '1', '感觉棒棒哒', '99', '7', '2', '0', '1');
INSERT INTO `menu` VALUES ('18', '/role/authorize', '权限设置', '', '1', '', '99', '6', '2', '0', '1');
INSERT INTO `menu` VALUES ('19', '/sign/index', '签到管理', '', '1', '', '99', '1', '1', '1', '0');
INSERT INTO `menu` VALUES ('20', 'wzgl', '文章管理', '', '1', '', '99', '0', '0', '1', '0');
INSERT INTO `menu` VALUES ('21', '/article/index', '文章列表', '', '1', '', '99', '20', '1', '1', '0');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0隐藏 1显示',
  `desc` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('2', '测试', '1', '测试测试');
INSERT INTO `role` VALUES ('3', '超级管理员3', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('4', '测试4', '1', '测试测试');
INSERT INTO `role` VALUES ('5', '超级管理员5', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('6', '测试6', '1', '测试测试');
INSERT INTO `role` VALUES ('7', '超级管理员7', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('8', '测试8', '1', '测试测试');
INSERT INTO `role` VALUES ('9', '超级管理员9', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('10', '测试10', '1', '测试测试');
INSERT INTO `role` VALUES ('11', '超级管理员11', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('12', '测试12', '1', '测试测试');
INSERT INTO `role` VALUES ('13', '超级管理员13', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('14', '测试14', '1', '测试测试');
INSERT INTO `role` VALUES ('15', '超级管理员15', '1', '超级管理员就是6');
INSERT INTO `role` VALUES ('16', '测试16', '1', '测试测试');

-- ----------------------------
-- Table structure for sign
-- ----------------------------
DROP TABLE IF EXISTS `sign`;
CREATE TABLE `sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '签到人ID',
  `sign_count` int(255) NOT NULL DEFAULT '0' COMMENT '连续签到次数',
  `last_sign_time` int(10) NOT NULL DEFAULT '0' COMMENT '最后签到时间',
  `sign_history` text COMMENT '签到历史',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sign
-- ----------------------------
INSERT INTO `sign` VALUES ('35', '2', '2', '1511452800', '[1511193600,1511366400,1511452800]');
INSERT INTO `sign` VALUES ('36', '1', '1', '1513526400', '[1511193600,1511280000,1511366400,1511452800,1511712000,1511798400,1511884800,1511971200,1512057600,1512316800,1512403200,1512489600,1512576000,1512662400,1512921600,1513008000,1513094400,1513180800,1513267200,1513526400]');
INSERT INTO `sign` VALUES ('37', '3', '2', '1511452800', '[1511366400,1511452800]');

-- ----------------------------
-- Table structure for sign_log
-- ----------------------------
DROP TABLE IF EXISTS `sign_log`;
CREATE TABLE `sign_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `create_at` int(10) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `integral` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sign_log
-- ----------------------------
INSERT INTO `sign_log` VALUES ('1', '2', '1511230491', '5');
INSERT INTO `sign_log` VALUES ('2', '1', '1511242531', '5');
INSERT INTO `sign_log` VALUES ('3', '1', '1511310274', '10');
INSERT INTO `sign_log` VALUES ('4', '1', '1511396210', '15');
INSERT INTO `sign_log` VALUES ('5', '3', '1511396345', '5');
INSERT INTO `sign_log` VALUES ('6', '2', '1511396396', '5');
INSERT INTO `sign_log` VALUES ('7', '2', '1511483257', '10');
INSERT INTO `sign_log` VALUES ('8', '1', '1511483301', '20');
INSERT INTO `sign_log` VALUES ('9', '3', '1511488904', '10');
INSERT INTO `sign_log` VALUES ('10', '1', '1511742225', '5');
INSERT INTO `sign_log` VALUES ('11', '1', '1511828549', '10');
INSERT INTO `sign_log` VALUES ('12', '1', '1511915080', '15');
INSERT INTO `sign_log` VALUES ('13', '1', '1512003856', '20');
INSERT INTO `sign_log` VALUES ('14', '1', '1512087796', '20');
INSERT INTO `sign_log` VALUES ('15', '1', '1512347009', '5');
INSERT INTO `sign_log` VALUES ('16', '1', '1512432891', '10');
INSERT INTO `sign_log` VALUES ('17', '1', '1512520371', '15');
INSERT INTO `sign_log` VALUES ('18', '1', '1512606121', '20');
INSERT INTO `sign_log` VALUES ('19', '1', '1512692553', '20');
INSERT INTO `sign_log` VALUES ('20', '1', '1512951896', '5');
INSERT INTO `sign_log` VALUES ('21', '1', '1513038047', '10');
INSERT INTO `sign_log` VALUES ('22', '1', '1513124622', '15');
INSERT INTO `sign_log` VALUES ('23', '1', '1513211038', '20');
INSERT INTO `sign_log` VALUES ('24', '1', '1513297295', '20');
INSERT INTO `sign_log` VALUES ('25', '1', '1513557177', '5');
