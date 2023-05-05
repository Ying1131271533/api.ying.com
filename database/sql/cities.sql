/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50540
 Source Host           : localhost:3306
 Source Schema         : cloudclass

 Target Server Type    : MySQL
 Target Server Version : 50540
 File Encoding         : 65001

 Date: 04/09/2019 17:28:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '代码',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `short_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '简称',
  `parent_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上级代码',
  `lng` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经度',
  `lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '纬度',
  `sort` int(6) NULL DEFAULT NULL COMMENT '排序',
  `gmt_create` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `gmt_modified` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `memo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `data_state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `tenant_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '租户ID',
  `level` tinyint(4) NULL DEFAULT NULL COMMENT '级别',
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `parent_code`(`parent_code`) USING BTREE,
  INDEX `code_tenant_code`(`code`, `tenant_code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46869 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '中国地区信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES (1, '110000', '北京', '北京', '000000', '116.405289', '39.904987', 1, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (2, '120000', '天津', '天津', '000000', '117.190186', '39.125595', 2, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (3, '130000', '河北省', '河北', '000000', '114.502464', '38.045475', 3, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (4, '140000', '山西省', '山西', '000000', '112.549248', '37.857014', 4, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (5, '150000', '内蒙古自治区', '内蒙古', '000000', '111.670799', '40.81831', 5, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (6, '210000', '辽宁省', '辽宁', '000000', '123.429092', '41.796768', 6, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (7, '220000', '吉林省', '吉林', '000000', '125.324501', '43.886841', 7, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (8, '230000', '黑龙江省', '黑龙江', '000000', '126.642464', '45.756966', 8, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (9, '310000', '上海', '上海', '000000', '121.472641', '31.231707', 9, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (10, '320000', '江苏省', '江苏', '000000', '118.76741', '32.041546', 10, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');
INSERT INTO `cities` VALUES (11, '330000', '浙江省', '浙江', '000000', '120.15358', '30.287458', 11, '2019-09-04 17:27:50', '2019-09-04 17:27:50', '', 0, '00000000', '1');

SET FOREIGN_KEY_CHECKS = 1;
