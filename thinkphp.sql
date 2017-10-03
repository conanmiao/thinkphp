/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : thinkphp

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 10/03/2017 20:01:27 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `create_time` int(20) NOT NULL COMMENT '创建时间',
  `Jurisdiction` int(1) NOT NULL DEFAULT '1' COMMENT '权限',
  `isdelete` int(1) NOT NULL DEFAULT '1' COMMENT '使用状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'admin', '202cb962ac59075b964b07152d234b70', '1499389622', '1', '1');
COMMIT;

-- ----------------------------
--  Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `config`
-- ----------------------------
BEGIN;
INSERT INTO `config` VALUES ('1', '', '', '', '', '', '', '', '');
COMMIT;

-- ----------------------------
--  Table structure for `friendlink`
-- ----------------------------
DROP TABLE IF EXISTS `friendlink`;
CREATE TABLE `friendlink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `friendlink`
-- ----------------------------
BEGIN;
INSERT INTO `friendlink` VALUES ('1', null, 'asd', 'http://www.baidu.com');
COMMIT;

-- ----------------------------
--  Table structure for `info`
-- ----------------------------
DROP TABLE IF EXISTS `info`;
CREATE TABLE `info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `info`
-- ----------------------------
BEGIN;
INSERT INTO `info` VALUES ('1', '企业简介', '<p>1232</p>'), ('2', '企业文化', '<p>asdfasd</p>'), ('3', '荣誉资质', '<p>asdfasdfasdfasdfasdfasdfasdfasdfa</p>'), ('4', '发展历程', '<p>asdfasdf</p>'), ('5', '商务合作', ''), ('6', '人才招聘', '');
COMMIT;

-- ----------------------------
--  Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `tel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `message`
-- ----------------------------
BEGIN;
INSERT INTO `message` VALUES ('1', '王老师', '18888888888', '123@qq.com', '我想做个网站', '131');
COMMIT;

-- ----------------------------
--  Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `view` int(11) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `news`
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES ('1', '1', '22公司简介22', '', '新闻cid应该是1才对', '<p>的方式发打发斯蒂芬</p>', '1501289391', '1501289391', '1', '0'), ('4', '13', '4141414', '', '1241412421', '', '1501145094', '1501145094', '1', '0'), ('66', '1', '新年新气象', '', '这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述这里描述', '<p>这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容这里是标题内容</p>', '1501148295', '1501148295', '1', '0'), ('67', '1', '测试第一次通过TP发布的产品', '20170801/2ef7497dd34afe7bbc46b85eefc7e414.png', '这里是产品描述', '', '1501591148', '1501591148', '1', '0'), ('68', '1', 'ceshi', '', null, null, '0', null, '1', '0'), ('69', '1', '这里是公司新闻', '', '这里是描述', '<p>详情</p>', '1501253668', '1501253668', '1', '0'), ('70', '1', '测试有图新闻', '', '', '<p>123123123</p>', '1501289153', '1501289153', '1', '0'), ('71', '1', '123123', '', '', '', '1501289081', '1501289081', '1', '0'), ('72', '1', '131231231', '', '', '', '1501289440', '1501289440', '1', '0'), ('73', '1', '图图图图图', '', '', '', '1501289453', '1501289453', '1', '0'), ('75', '1', 'youtu', '', '', '', '1501289812', '1501289812', '1', '0'), ('78', '1', '编辑 有图', '', '', '', '1501291654', '1501291654', '1', '0'), ('80', '1', '新增 无图', '', '', '', '1501290263', '1501290263', '1', '0'), ('81', '1', '新增 有图', '', '', '', '1501290275', '1501290275', '1', '0'), ('82', '1', '发布有图', '', '', '', '1501291071', '1501291071', '1', '0'), ('84', '1', '编辑 有图了', '20170730/b61cab019cb5b47a4b01a5d2db407844.png', '', '', '1501417547', '1501417547', '1', '0'), ('86', '1', '新文章在这里', '20170730/0b176a22eb102f975781f775b1337e46.png', '', '<p>12312321</p>', '1501591217', '1501591217', '1', '0'), ('87', '1', '新的方法 处理input', '20170805/3b9eb604591a8ed5f4cb84210daf2735.png', '这里是描述', null, '1501923699', '1501923699', '1', '1'), ('88', '1', '又一次测试input函数', '20170805/0bb8938a9bc9be50b2c896dd484951db.png', '咕咕咕咕过', '<p>sssss<br/></p>', '1501924083', '1501924083', '1', '2');
COMMIT;

-- ----------------------------
--  Table structure for `newscate`
-- ----------------------------
DROP TABLE IF EXISTS `newscate`;
CREATE TABLE `newscate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `catename` varchar(50) NOT NULL,
  `cateorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序值',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `newscate`
-- ----------------------------
BEGIN;
INSERT INTO `newscate` VALUES ('1', '0', '公司新闻', '0', '1', null), ('2', '0', '行业资讯', '0', '1', null), ('3', '0', '优秀软文', '0', '1', null), ('4', '1', '1-11新闻', '0', '1', null), ('5', '1', '1-2新闻1', '0', '1', null), ('6', '2', '2-1新闻', '0', '1', null), ('8', '3', '3-1新闻', '0', '1', null), ('9', '3', '3-2新闻', '0', '1', null), ('11', '10', '大一二212', '0', '1', null);
COMMIT;

-- ----------------------------
--  Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL DEFAULT '',
  `price` float(11,2) NOT NULL DEFAULT '0.00',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `content` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '1',
  `isdelete` tinyint(4) NOT NULL DEFAULT '0',
  `view` int(11) NOT NULL DEFAULT '0',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `spare` varchar(255) DEFAULT NULL COMMENT '备用',
  `order` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `product`
-- ----------------------------
BEGIN;
INSERT INTO `product` VALUES ('6', '1', '333', '', '0.00', '', '', '1499652325', '1499652325', '1', '0', '0', null, null, '0'), ('7', '1', '444', '', '0.00', '', '', '1499652329', '1499652329', '1', '0', '0', null, null, '0'), ('8', '1', '555', '', '0.00', '', '', '1499652332', '1499652332', '0', '0', '0', null, null, '0'), ('9', '1', '666', '', '0.00', '', '', '1499652344', '1499652344', '0', '0', '0', null, null, '0'), ('10', '1', '7777', '', '0.00', '', '', '1499652353', '1499652353', '0', '0', '0', null, null, '0'), ('14', '1', '编辑无图模式', '20170801/0c898c64f73b298f4634f93bdfaa93d8.png', '199.00', '测试描述显示的字数情况测试描述显示的字数情况测试描述显示的字数情况测试描述显示的字数情况测试描述显示的字数情况测试描述显示的字数情况', '', '1501574810', '1501574810', '0', '0', '0', null, null, '0'), ('15', '1', '发布无图模式', '20170801/d3433ead70c1b7d5e6a4ef5de88b8aeb.png', '0.00', '', '<p>123123123123</p>', '1501591312', '1501591312', '1', '0', '0', null, null, '0'), ('16', '1', '发布有图模式', '', '0.00', '', '', '1501293984', '1501293984', '1', '0', '0', null, null, '0'), ('17', '1', 'asdfasd', '20170801/92f59b1d7bbd442e6a372ee044439490.png', '0.00', '', '<p>123</p>', '1501593869', '1501593869', '1', '0', '0', null, null, '0'), ('18', '1', '最新产品标题', '20170801/e8ddf2e2f394e324c291d1e7e2f9b5fa.png', '0.00', '', '<p>231<br/></p>', '1501548412', '1501548412', '1', '0', '0', null, null, '3'), ('19', '1', '12312312', '20170801/dbfd8314cee994f656cd2a8ba7433db0.png', '0.00', '', '<p>123123123</p>', '1501593880', '1501593880', '1', '0', '0', null, null, '0'), ('20', '1', 'ddddd', '', '0.00', '', '', '1501766680', '1501766680', '1', '0', '0', null, null, '0'), ('21', '1', 'kkkkk', '', '0.00', '', '', '1501767224', '1501767224', '1', '0', '0', null, null, '0'), ('22', '1', 'jjjj', '20170805/c17210b84cfdf30f67efbb2e94dfd516.jpg', '0.00', '', '', '1501929414', '1501929414', '1', '0', '0', null, null, '0'), ('23', '1', '你知道吗，这个是我的女神', '20170805/8b77fb561613a9592cc95608f6c7b6b8.png', '0.00', '这里是描述', '<p>这里是详情</p>', '1501925054', '1501925054', '1', '0', '0', null, null, '2'), ('24', '1', '结核杆菌恢诡谲怪', '20170807/1fdb62b8d8ec21120e614b4617a5e8c8.jpg', '0.00', '闻风丧胆的', '<p>在vsdfg</p>', '1502101311', '1502101311', '1', '0', '0', null, null, '0');
COMMIT;

-- ----------------------------
--  Table structure for `productcate`
-- ----------------------------
DROP TABLE IF EXISTS `productcate`;
CREATE TABLE `productcate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catename` varchar(255) DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `isdelete` tinyint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `productcate`
-- ----------------------------
BEGIN;
INSERT INTO `productcate` VALUES ('1', '定制开发', '0', '0'), ('2', '微信公众号开发', '0', '0'), ('3', 'APP开发', '0', '0'), ('4', '电商平台类', '0', '0'), ('5', '定制开发官网2', '1', '0'), ('6', '定制开发软件', '1', '0'), ('7', '微信公众服务号', '2', '0'), ('8', '微信公众订阅号', '2', '0'), ('9', 'APP游戏开发', '3', '0'), ('10', 'APP商城开发', '3', '0'), ('11', '定制开发官网', '0', '0'), ('16', '22222222', '5', '0'), ('17', '定制开发222', '1', '0');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `create_time` int(20) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `Jurisdiction` int(1) NOT NULL DEFAULT '1' COMMENT '权限',
  `isdelete` int(1) NOT NULL DEFAULT '1' COMMENT '使用状态',
  `name` varchar(255) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'conanmiao', '202cb962ac59075b964b07152d234b70', '1499389622', '1', '1', '大苗', '18888888888'), ('2', 'damiao', '202cb962ac59075b964b07152d234b70', '1499399999', '1', '1', '小苗', '16666666666'), ('3', 'zhangsan', '123', '1502082597', '1', '1', '张三', '19999999999'), ('5', 'zzw', '202cb962ac59075b964b07152d234b70', '1502082889', '1', '1', '赵责问', '18888888222'), ('6', 'zzw', '202cb962ac59075b964b07152d234b70', '1502082932', '1', '1', '赵泽文', '18888888222'), ('9', 'zhangshangyi', '202cb962ac59075b964b07152d234b70', '1502090729', '1', '1', '张尚义', '13888888680'), ('10', 'adsfasdfa', '202cb962ac59075b964b07152d234b70', '1502091180', '1', '1', '112', '1231'), ('11', 'ad1111min', '658d128f20ee88e00e9607a475cdfaa5', '1502091186', '1', '1', '', ''), ('12', 'admin1111', '202cb962ac59075b964b07152d234b70', '1502091194', '1', '1', '', '11'), ('13', '999999999999999', 'f1290186a5d0b1ceab27f4e77c0c5d68', '1502091671', '1', '1', '', '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
