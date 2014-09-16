/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : resultdb

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-09-11 11:48:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ref_scaling
-- ----------------------------
DROP TABLE IF EXISTS `ref_scaling`;
CREATE TABLE `ref_scaling` (
  `scaling_name` varchar(255) DEFAULT NULL,
  `raw_value` int(11) DEFAULT NULL,
  `scaled_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_scaling
-- ----------------------------

-- ----------------------------
-- Table structure for results
-- ----------------------------
DROP TABLE IF EXISTS `results`;
CREATE TABLE `results` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rapor_item_id` bigint(20) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `tao_delivery` varchar(255) DEFAULT NULL,
  `tao_delivery_execution` varchar(255) DEFAULT NULL,
  `tao_delivery_result` varchar(255) DEFAULT NULL,
  `tao_delivery_label` varchar(255) DEFAULT NULL,
  `tao_subject` varchar(255) DEFAULT NULL,
  `result_json` longtext,
  `scores_string` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of results
-- ----------------------------
INSERT INTO `results` VALUES ('21', '1', '2014-09-10 18:32:06', 'http://127.0.0.1/tao/thinkpad.rdf#i1410250951475127', 'http://127.0.0.1/tao/thinkpad.rdf#i14103487163442399', 'http://127.0.0.1/tao/thinkpad.rdf#i14103487176813400', 'Delivery of Test 1', 'http://127.0.0.1/tao/thinkpad.rdf#i1410243872961112', '{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103487245185401\":{\"duration\":\"UFQ2Uw==\",\"completionStatus\":\"Y29tcGxldGVk\",\"SCORE\":\"MQ==\",\"RESPONSE\":\"WydjaG9pY2VfMidd\",\"numAttempts\":\"MQ==\"}}', '[{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103487245185401\":\"1\"}]');
INSERT INTO `results` VALUES ('24', null, '2014-09-10 18:35:59', 'http://127.0.0.1/tao/thinkpad.rdf#i1410250951475127', 'http://127.0.0.1/tao/thinkpad.rdf#i14103489499315426', 'http://127.0.0.1/tao/thinkpad.rdf#i14103489505389427', 'Delivery of Test 1', 'http://127.0.0.1/tao/thinkpad.rdf#i1410243872961112', '{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103489588537428\":{\"RESPONSE\":\"WydjaG9pY2VfMidd\",\"duration\":\"UFQ3Uw==\",\"SCORE\":\"MQ==\",\"completionStatus\":\"Y29tcGxldGVk\",\"numAttempts\":\"MQ==\"}}', '[{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103489588537428\":\"1\"}]');
INSERT INTO `results` VALUES ('25', '1', '2014-09-11 02:10:10', 'http://127.0.0.1/tao/thinkpad.rdf#i1410250951475127', 'http://127.0.0.1/tao/thinkpad.rdf#i14103761928636435', 'http://127.0.0.1/tao/thinkpad.rdf#i14103761933894436', 'Delivery of Test 1', 'http://127.0.0.1/tao/thinkpad.rdf#i1410243872961112', '{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103762083391437\":{\"RESPONSE\":\"WydjaG9pY2VfMidd\",\"SCORE\":\"MQ==\",\"duration\":\"UFQxMVM=\",\"numAttempts\":\"MQ==\",\"completionStatus\":\"Y29tcGxldGVk\"}}', '[{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103762083391437\":\"1\"}]');
INSERT INTO `results` VALUES ('26', '1', '2014-09-11 02:10:59', 'http://127.0.0.1/tao/thinkpad.rdf#i1410250951475127', 'http://127.0.0.1/tao/thinkpad.rdf#i14103762439784444', 'http://127.0.0.1/tao/thinkpad.rdf#i14103762446881445', 'Delivery of Test 1', 'http://127.0.0.1/tao/thinkpad.rdf#i1410243872961112', '{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103762571986446\":{\"RESPONSE\":\"WydjaG9pY2VfMidd\",\"numAttempts\":\"MQ==\",\"duration\":\"UFQxMlM=\",\"completionStatus\":\"Y29tcGxldGVk\",\"SCORE\":\"MQ==\"}}', '[{\"http:\\/\\/127.0.0.1\\/tao\\/thinkpad.rdf#i14103762571986446\":\"1\"}]');
