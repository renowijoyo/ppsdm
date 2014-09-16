/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : rapordb

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-09-11 11:48:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for assessment
-- ----------------------------
DROP TABLE IF EXISTS `assessment`;
CREATE TABLE `assessment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `tao_subject` varchar(255) DEFAULT NULL,
  `item_template_id` bigint(20) DEFAULT NULL,
  `tao_delivery_label` varchar(255) DEFAULT NULL,
  `tao_delivery_result` varchar(255) DEFAULT NULL,
  `tao_delivery_status` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `connection(profile)` (`profile_id`),
  KEY `assessment.item_template_id` (`item_template_id`),
  CONSTRAINT `assessment.item_template_id` FOREIGN KEY (`item_template_id`) REFERENCES `item_template` (`id`),
  CONSTRAINT `connection(profile)` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of assessment
-- ----------------------------

-- ----------------------------
-- Table structure for education
-- ----------------------------
DROP TABLE IF EXISTS `education`;
CREATE TABLE `education` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `academic_level_id` varchar(255) DEFAULT NULL,
  `institution_id` varchar(255) DEFAULT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `graduate_year` int(11) DEFAULT NULL,
  `grade` double DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `education_uinique` (`profile_id`,`institution_id`),
  CONSTRAINT `education>profile(profile_id)` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of education
-- ----------------------------

-- ----------------------------
-- Table structure for eportfolio
-- ----------------------------
DROP TABLE IF EXISTS `eportfolio`;
CREATE TABLE `eportfolio` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eportfolio_template_id` int(11) DEFAULT NULL,
  `profile_id` bigint(20) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eportfolio.eportfolio_template_id` (`eportfolio_template_id`),
  KEY `eportfolio.profile_id` (`profile_id`),
  CONSTRAINT `eportfolio.eportfolio_template_id` FOREIGN KEY (`eportfolio_template_id`) REFERENCES `eportfolio_template` (`id`),
  CONSTRAINT `eportfolio.profile_id` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of eportfolio
-- ----------------------------
INSERT INTO `eportfolio` VALUES ('1', '1', '1', null, 'unpaid');
INSERT INTO `eportfolio` VALUES ('2', '2', '1', null, 'unpaid');
INSERT INTO `eportfolio` VALUES ('6', '2', '14', '2014-09-09 12:59:47', 'unpaid');
INSERT INTO `eportfolio` VALUES ('7', '1', '14', '2014-09-10 09:09:36', 'unpaid');

-- ----------------------------
-- Table structure for eportfolio_template
-- ----------------------------
DROP TABLE IF EXISTS `eportfolio_template`;
CREATE TABLE `eportfolio_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `image_url` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tags` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of eportfolio_template
-- ----------------------------
INSERT INTO `eportfolio_template` VALUES ('1', 'ppsdm/psikotes/smu', 'psikotes', 'tes psikotes', null, 'active', null);
INSERT INTO `eportfolio_template` VALUES ('2', 'ppsdm/bakat&minat/smu', 'iq & minat', 'tes iq & minat', null, 'active', null);

-- ----------------------------
-- Table structure for eportfolio_template_item
-- ----------------------------
DROP TABLE IF EXISTS `eportfolio_template_item`;
CREATE TABLE `eportfolio_template_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eportfolio_template_id` int(11) DEFAULT NULL,
  `item_template_id` bigint(20) DEFAULT NULL,
  `requirements` text,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eportfolio_template_item.item_template_id` (`item_template_id`),
  KEY `eportfolio_template_item.eportfolio_template_id` (`eportfolio_template_id`),
  CONSTRAINT `eportfolio_template_item.eportfolio_template_id` FOREIGN KEY (`eportfolio_template_id`) REFERENCES `eportfolio_template` (`id`),
  CONSTRAINT `eportfolio_template_item.item_template_id` FOREIGN KEY (`item_template_id`) REFERENCES `item_template` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of eportfolio_template_item
-- ----------------------------
INSERT INTO `eportfolio_template_item` VALUES ('1', '1', '1', null, null);
INSERT INTO `eportfolio_template_item` VALUES ('2', '1', '2', null, null);
INSERT INTO `eportfolio_template_item` VALUES ('3', '1', '3', null, null);
INSERT INTO `eportfolio_template_item` VALUES ('4', '2', '4', null, null);
INSERT INTO `eportfolio_template_item` VALUES ('5', '2', '5', null, null);

-- ----------------------------
-- Table structure for family
-- ----------------------------
DROP TABLE IF EXISTS `family`;
CREATE TABLE `family` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relation_type_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_id -> relation` (`profile_id`),
  CONSTRAINT `profile_id -> relation` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of family
-- ----------------------------

-- ----------------------------
-- Table structure for institution
-- ----------------------------
DROP TABLE IF EXISTS `institution`;
CREATE TABLE `institution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text,
  `academic_level_id` varchar(255) DEFAULT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of institution
-- ----------------------------

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_template_id` bigint(20) DEFAULT NULL,
  `eportfolio_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `item.item_template.id` (`item_template_id`),
  KEY `item.eportfolio_id` (`eportfolio_id`),
  CONSTRAINT `item.eportfolio_id` FOREIGN KEY (`eportfolio_id`) REFERENCES `eportfolio` (`id`),
  CONSTRAINT `item.item_template.id` FOREIGN KEY (`item_template_id`) REFERENCES `item_template` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', '1', '1', 'pending', null);
INSERT INTO `item` VALUES ('2', '1', '1', null, null);
INSERT INTO `item` VALUES ('3', '1', '1', null, null);
INSERT INTO `item` VALUES ('4', '1', null, null, null);
INSERT INTO `item` VALUES ('5', '1', null, null, null);
INSERT INTO `item` VALUES ('6', '4', null, null, null);
INSERT INTO `item` VALUES ('7', '5', null, null, null);
INSERT INTO `item` VALUES ('8', '4', '6', null, null);
INSERT INTO `item` VALUES ('9', '5', '6', null, null);
INSERT INTO `item` VALUES ('10', '1', '7', null, null);
INSERT INTO `item` VALUES ('11', '2', '7', null, null);
INSERT INTO `item` VALUES ('12', '3', '7', null, null);

-- ----------------------------
-- Table structure for item_template
-- ----------------------------
DROP TABLE IF EXISTS `item_template`;
CREATE TABLE `item_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text,
  `status` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `result_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_template
-- ----------------------------
INSERT INTO `item_template` VALUES ('1', 'subtest 1', 'subtest', 'subtest 1', 'active', 'http://127.0.0.1/tao/thinkpad.rdf#i1410250951475127', null, null);
INSERT INTO `item_template` VALUES ('2', 'subtest 2', 'subtest', 'subtest 2', 'active', 'http://127.0.0.1/tao/thinkpad.rdf#i1410251136444538', null, null);
INSERT INTO `item_template` VALUES ('3', 'subtest 3', 'subtest', 'subtest 3', 'active', null, null, null);
INSERT INTO `item_template` VALUES ('4', 'subtest 4', 'subtest', 'subtest 4', 'active', null, null, null);
INSERT INTO `item_template` VALUES ('5', 'subtest 5', 'subtest', 'subtest 5', 'active', null, null, null);

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log
-- ----------------------------

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `gender_id` varchar(255) DEFAULT NULL,
  `religion_id` varchar(255) DEFAULT NULL,
  `nationality_id` varchar(255) DEFAULT NULL,
  `ethnicity_id` varchar(255) DEFAULT NULL,
  `marriage_status_id` varchar(255) DEFAULT NULL,
  `number_of_children` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id(email)` (`user_id`),
  CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', '1', 'reno', 'wijoyo', null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('2', '2', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('3', '3', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('4', '4', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('5', '5', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('6', '6', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('7', '7', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('8', '8', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('9', '9', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('10', '10', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('11', '11', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('12', '12', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('13', '13', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `profile` VALUES ('14', '14', 'nina', 'lalala', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for profile_address
-- ----------------------------
DROP TABLE IF EXISTS `profile_address`;
CREATE TABLE `profile_address` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `province_id` varchar(255) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_adress_profile_id` (`profile_id`),
  CONSTRAINT `profile_adress_profile_id` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profile_address
-- ----------------------------

-- ----------------------------
-- Table structure for profile_contact
-- ----------------------------
DROP TABLE IF EXISTS `profile_contact`;
CREATE TABLE `profile_contact` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `primary_no` varchar(255) DEFAULT '',
  `primary_type_id` varchar(255) DEFAULT NULL,
  `secondary_no` varchar(255) DEFAULT '',
  `secondary_type_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `primary_type_id` (`primary_type_id`),
  KEY `secondary_type_id` (`secondary_type_id`),
  KEY `contact_profile_id` (`profile_id`),
  CONSTRAINT `contact_profile_id` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`),
  CONSTRAINT `primary_type_id` FOREIGN KEY (`primary_type_id`) REFERENCES `reference` (`reference_key`),
  CONSTRAINT `secondary_type_id` FOREIGN KEY (`secondary_type_id`) REFERENCES `reference` (`reference_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profile_contact
-- ----------------------------

-- ----------------------------
-- Table structure for reference
-- ----------------------------
DROP TABLE IF EXISTS `reference`;
CREATE TABLE `reference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `reference_key` varchar(255) DEFAULT NULL,
  `reference_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_index` (`reference_key`,`context`,`category`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reference
-- ----------------------------
INSERT INTO `reference` VALUES ('3', null, 'gender', 'Male', 'male');
INSERT INTO `reference` VALUES ('4', null, 'gender', 'Female', 'female');
INSERT INTO `reference` VALUES ('5', null, 'religion', 'Other', 'other');
INSERT INTO `reference` VALUES ('6', null, 'religion', 'Islam', 'islam');
INSERT INTO `reference` VALUES ('7', null, 'religion', 'Hindu', 'hindu');
INSERT INTO `reference` VALUES ('8', null, 'religion', 'Protestant', 'protestant');
INSERT INTO `reference` VALUES ('9', null, 'religion', 'Catholic', 'catholic');
INSERT INTO `reference` VALUES ('10', null, 'religion', 'Buddha', 'buddha');
INSERT INTO `reference` VALUES ('11', null, 'religion', 'Confucius', 'confucius');
INSERT INTO `reference` VALUES ('12', null, 'marriage_status', 'Married', 'married');
INSERT INTO `reference` VALUES ('13', null, 'marriage_status', 'Single', 'single');
INSERT INTO `reference` VALUES ('14', null, 'marriage_status', 'Separated', 'separated');
INSERT INTO `reference` VALUES ('15', null, 'marriage_status', 'Divorced', 'divorced');
INSERT INTO `reference` VALUES ('16', null, 'marriage_status', 'Widowed', 'widowed');
INSERT INTO `reference` VALUES ('17', null, 'marriage_status', 'Other', 'other');
INSERT INTO `reference` VALUES ('18', null, 'user_status', 'unvalidated', 'unvalidated');
INSERT INTO `reference` VALUES ('19', null, 'user_status', 'validated', 'validated');
INSERT INTO `reference` VALUES ('20', null, 'user_status', 'profile', 'profile');
INSERT INTO `reference` VALUES ('21', null, 'user_status', 'profile,photo', 'profile,photo');
INSERT INTO `reference` VALUES ('22', null, 'academic_level', 'tk', 'kindergarten');
INSERT INTO `reference` VALUES ('23', null, 'academic_level', 'sd', 'elementary');
INSERT INTO `reference` VALUES ('24', null, 'academic_level', 'smp', 'junior high');
INSERT INTO `reference` VALUES ('25', null, 'academic_level', 'sma', 'high school');
INSERT INTO `reference` VALUES ('26', null, 'academic_level', 's1', 'bachelor');
INSERT INTO `reference` VALUES ('27', null, 'academic_level', 's2', 'master');
INSERT INTO `reference` VALUES ('28', null, 'academic_level', 's3', 'doctorate');
INSERT INTO `reference` VALUES ('29', null, 'contact_type', 'home', 'home');
INSERT INTO `reference` VALUES ('30', null, 'contact_type', 'work', 'work');
INSERT INTO `reference` VALUES ('31', null, 'contact_type', 'mobile', 'mobile');
INSERT INTO `reference` VALUES ('32', null, 'contact_type', 'other', 'other');
INSERT INTO `reference` VALUES ('33', null, 'relation_type', 'sibling', 'sibling');
INSERT INTO `reference` VALUES ('34', null, 'relation_type', 'parent', 'parent');
INSERT INTO `reference` VALUES ('35', null, 'relation_type', 'children', 'children');
INSERT INTO `reference` VALUES ('36', null, 'relation_type', 'other', 'other');
INSERT INTO `reference` VALUES ('37', null, 'ethnicity', 'other', 'other');
INSERT INTO `reference` VALUES ('38', null, 'ethnicity', 'batak', 'batak');
INSERT INTO `reference` VALUES ('39', null, 'ethnicity', 'jawa', 'jawa');
INSERT INTO `reference` VALUES ('40', null, 'ethnicity', 'sunda', 'sunda');
INSERT INTO `reference` VALUES ('41', null, 'ethnicity', 'chinese', 'chinese');
INSERT INTO `reference` VALUES ('48', null, 'place', 'other', 'other');
INSERT INTO `reference` VALUES ('49', null, 'place', 'jakarta,dki', 'Jakarta, DKI');
INSERT INTO `reference` VALUES ('50', null, 'place', 'bandung,jabar', 'Bandung, Jabar');
INSERT INTO `reference` VALUES ('51', null, 'industry', 'other', 'other');
INSERT INTO `reference` VALUES ('52', null, 'industry', 'computer technology', 'computer technology');
INSERT INTO `reference` VALUES ('53', null, 'industry', 'social service', 'social service');
INSERT INTO `reference` VALUES ('56', null, 'nationality', 'indonesia', 'indonesia');
INSERT INTO `reference` VALUES ('57', null, 'nationality', 'other', 'other');
INSERT INTO `reference` VALUES ('58', null, 'country', 'indonesia', 'indonesia');
INSERT INTO `reference` VALUES ('59', null, 'country', 'other', 'other');
INSERT INTO `reference` VALUES ('66', null, 'academic_level', 'n/a', 'n/a');
INSERT INTO `reference` VALUES ('67', null, 'academic_level', 'd1', 'd1');
INSERT INTO `reference` VALUES ('68', null, 'academic_level', 'd2', 'd2');
INSERT INTO `reference` VALUES ('69', null, 'academic_level', 'd3', 'd3');
INSERT INTO `reference` VALUES ('70', null, 'relation_type', 'wife', 'wife');
INSERT INTO `reference` VALUES ('71', null, 'relation_type', 'husband', 'husband');
INSERT INTO `reference` VALUES ('72', null, 'ethnicity', 'aceh', 'aceh');
INSERT INTO `reference` VALUES ('73', null, 'ethnicity', 'ambon', 'ambon');
INSERT INTO `reference` VALUES ('74', null, 'ethnicity', 'bali', 'bali');
INSERT INTO `reference` VALUES ('75', null, 'ethnicity', 'bugis', 'bugis');
INSERT INTO `reference` VALUES ('76', null, 'ethnicity', 'caucasian', 'caucasian');
INSERT INTO `reference` VALUES ('77', null, 'ethnicity', 'dayak', 'dayak');
INSERT INTO `reference` VALUES ('78', null, 'ethnicity', 'eurasian', 'eurasian');
INSERT INTO `reference` VALUES ('79', null, 'ethnicity', 'india', 'india');
INSERT INTO `reference` VALUES ('80', null, 'ethnicity', 'makasar', 'makasar');
INSERT INTO `reference` VALUES ('81', null, 'ethnicity', 'manado', 'manado');
INSERT INTO `reference` VALUES ('82', null, 'ethnicity', 'melayu', 'melayu');
INSERT INTO `reference` VALUES ('83', null, 'ethnicity', 'middle-eastern', 'middle-eastern');
INSERT INTO `reference` VALUES ('84', null, 'ethnicity', 'padang', 'padang');
INSERT INTO `reference` VALUES ('85', null, 'ethnicity', 'tapanuli', 'tapanuli');
INSERT INTO `reference` VALUES ('86', null, 'ethnicity', 'timor', 'timor');
INSERT INTO `reference` VALUES ('87', null, 'major', 'ADMINISTRASI PENDIDIKAN', 'ADMINISTRASI PENDIDIKAN');
INSERT INTO `reference` VALUES ('88', null, 'major', 'Agribisnis', 'Agribisnis');
INSERT INTO `reference` VALUES ('89', null, 'major', 'Agronomi ', 'Agronomi ');
INSERT INTO `reference` VALUES ('90', null, 'major', 'Agroteknologi', 'Agroteknologi');
INSERT INTO `reference` VALUES ('91', null, 'major', 'Akuntansi', 'Akuntansi');
INSERT INTO `reference` VALUES ('93', null, 'major', 'Antropologi', 'Antropologi');
INSERT INTO `reference` VALUES ('94', null, 'major', 'Arsitektur ', 'Arsitektur ');
INSERT INTO `reference` VALUES ('95', null, 'major', 'BAHASA DAN SASTRA INDONESIA', 'BAHASA DAN SASTRA INDONESIA');
INSERT INTO `reference` VALUES ('96', null, 'major', 'BAHASA DAN SASTRA INGGRIS', 'BAHASA DAN SASTRA INGGRIS');
INSERT INTO `reference` VALUES ('97', null, 'major', 'BIMBINGAN DAN KONSELING', 'BIMBINGAN DAN KONSELING');
INSERT INTO `reference` VALUES ('98', null, 'major', 'Biologi', 'Biologi');
INSERT INTO `reference` VALUES ('100', null, 'major', 'Budidaya Perikanan ', 'Budidaya Perikanan ');
INSERT INTO `reference` VALUES ('101', null, 'major', 'Ekonomi Pembangunan', 'Ekonomi Pembangunan');
INSERT INTO `reference` VALUES ('102', null, 'major', 'Elektronika dan Instrumentasi ', 'Elektronika dan Instrumentasi ');
INSERT INTO `reference` VALUES ('103', null, 'major', 'Farmasi', 'Farmasi');
INSERT INTO `reference` VALUES ('104', null, 'major', 'Fisika', 'Fisika');
INSERT INTO `reference` VALUES ('106', null, 'major', 'Fisika Teknik ', 'Fisika Teknik ');
INSERT INTO `reference` VALUES ('107', null, 'major', 'Geofisika', 'Geofisika');
INSERT INTO `reference` VALUES ('108', null, 'major', 'Geografi dan Ilmu Lingkungan', 'Geografi dan Ilmu Lingkungan');
INSERT INTO `reference` VALUES ('109', null, 'major', 'Gizi Kesehatan ', 'Gizi Kesehatan ');
INSERT INTO `reference` VALUES ('110', null, 'major', 'Ilmu Administrasi Bisnis', 'Ilmu Administrasi Bisnis');
INSERT INTO `reference` VALUES ('111', null, 'major', 'Ilmu Administrasi Negara', 'Ilmu Administrasi Negara');
INSERT INTO `reference` VALUES ('112', null, 'major', 'Ilmu dan Industri Peternakan ', 'Ilmu dan Industri Peternakan ');
INSERT INTO `reference` VALUES ('113', null, 'major', 'Ilmu Ekonomi dan Keuangan Islam', 'Ilmu Ekonomi dan Keuangan Islam');
INSERT INTO `reference` VALUES ('114', null, 'major', 'Ilmu Hama & Penyakit Tumbuhan', 'Ilmu Hama & Penyakit Tumbuhan');
INSERT INTO `reference` VALUES ('115', null, 'major', 'Ilmu Hubungan Internasional', 'Ilmu Hubungan Internasional');
INSERT INTO `reference` VALUES ('116', null, 'major', 'Ilmu Hukum', 'Ilmu Hukum');
INSERT INTO `reference` VALUES ('117', null, 'major', 'Ilmu Kelautan', 'Ilmu Kelautan');
INSERT INTO `reference` VALUES ('118', null, 'major', 'Ilmu Keolahragaan', 'Ilmu Keolahragaan');
INSERT INTO `reference` VALUES ('119', null, 'major', 'Ilmu Keperawatan', 'Ilmu Keperawatan');
INSERT INTO `reference` VALUES ('120', null, 'major', 'Ilmu Keperawatan Gigi', 'Ilmu Keperawatan Gigi');
INSERT INTO `reference` VALUES ('121', null, 'major', 'Ilmu Kesejahteraan Sosial', 'Ilmu Kesejahteraan Sosial');
INSERT INTO `reference` VALUES ('122', null, 'major', 'Ilmu Komputer', 'Ilmu Komputer');
INSERT INTO `reference` VALUES ('123', null, 'major', 'Ilmu Komunikasi', 'Ilmu Komunikasi');
INSERT INTO `reference` VALUES ('124', null, 'major', 'Ilmu Pemerintahan', 'Ilmu Pemerintahan');
INSERT INTO `reference` VALUES ('125', null, 'major', 'Ilmu Pendidikan Agama Islam', 'Ilmu Pendidikan Agama Islam');
INSERT INTO `reference` VALUES ('126', null, 'major', 'Ilmu Perpustakaan', 'Ilmu Perpustakaan');
INSERT INTO `reference` VALUES ('127', null, 'major', 'Ilmu Peternakan', 'Ilmu Peternakan');
INSERT INTO `reference` VALUES ('128', null, 'major', 'Ilmu Sejarah', 'Ilmu Sejarah');
INSERT INTO `reference` VALUES ('129', null, 'major', 'Ilmu Tanah', 'Ilmu Tanah');
INSERT INTO `reference` VALUES ('130', null, 'major', 'Kartografi dan Pengindraan Jauh ', 'Kartografi dan Pengindraan Jauh ');
INSERT INTO `reference` VALUES ('131', null, 'major', 'Kedokteran Hewan ', 'Kedokteran Hewan ');
INSERT INTO `reference` VALUES ('132', null, 'major', 'Kehutanan ', 'Kehutanan ');
INSERT INTO `reference` VALUES ('133', null, 'major', 'Kimia', 'Kimia');
INSERT INTO `reference` VALUES ('134', null, 'major', 'Manaj. Sumber Daya Perikanan', 'Manaj. Sumber Daya Perikanan');
INSERT INTO `reference` VALUES ('135', null, 'major', 'Manajemen', 'Manajemen');
INSERT INTO `reference` VALUES ('136', null, 'major', 'MANAJEMEN INDUSTRI KATERING', 'MANAJEMEN INDUSTRI KATERING');
INSERT INTO `reference` VALUES ('137', null, 'major', 'MANAJEMEN PEMASARAN PARIWISATA', 'MANAJEMEN PEMASARAN PARIWISATA');
INSERT INTO `reference` VALUES ('138', null, 'major', 'Matematika', 'Matematika');
INSERT INTO `reference` VALUES ('139', null, 'major', 'Mikrobiologi Pertanian ', 'Mikrobiologi Pertanian ');
INSERT INTO `reference` VALUES ('140', null, 'major', 'Pembangunan Wilayah', 'Pembangunan Wilayah');
INSERT INTO `reference` VALUES ('141', null, 'major', 'Pemuliaan Tanaman', 'Pemuliaan Tanaman');
INSERT INTO `reference` VALUES ('142', null, 'major', 'PENDIDIKAN AKUNTANSI', 'PENDIDIKAN AKUNTANSI');
INSERT INTO `reference` VALUES ('143', null, 'major', 'PENDIDIKAN BAHASA ARAB', 'PENDIDIKAN BAHASA ARAB');
INSERT INTO `reference` VALUES ('144', null, 'major', 'PENDIDIKAN BAHASA DAERAH', 'PENDIDIKAN BAHASA DAERAH');
INSERT INTO `reference` VALUES ('145', null, 'major', 'PENDIDIKAN BAHASA INGGRIS', 'PENDIDIKAN BAHASA INGGRIS');
INSERT INTO `reference` VALUES ('146', null, 'major', 'PENDIDIKAN BAHASA JEPANG', 'PENDIDIKAN BAHASA JEPANG');
INSERT INTO `reference` VALUES ('147', null, 'major', 'PENDIDIKAN BAHASA JERMAN', 'PENDIDIKAN BAHASA JERMAN');
INSERT INTO `reference` VALUES ('148', null, 'major', 'PENDIDIKAN BAHASA PERANCIS', 'PENDIDIKAN BAHASA PERANCIS');
INSERT INTO `reference` VALUES ('149', null, 'major', 'PENDIDIKAN BHS DAN SASTRA INDONESIA', 'PENDIDIKAN BHS DAN SASTRA INDONESIA');
INSERT INTO `reference` VALUES ('150', null, 'major', 'PENDIDIKAN BIOLOGI', 'PENDIDIKAN BIOLOGI');
INSERT INTO `reference` VALUES ('151', null, 'major', 'Pendidikan Dokter', 'Pendidikan Dokter');
INSERT INTO `reference` VALUES ('152', null, 'major', 'PENDIDIKAN EKONOMI', 'PENDIDIKAN EKONOMI');
INSERT INTO `reference` VALUES ('153', null, 'major', 'PENDIDIKAN FISIKA', 'PENDIDIKAN FISIKA');
INSERT INTO `reference` VALUES ('154', null, 'major', 'PENDIDIKAN GEOGRAFI', 'PENDIDIKAN GEOGRAFI');
INSERT INTO `reference` VALUES ('155', null, 'major', 'PENDIDIKAN ILMU KOMPUTER', 'PENDIDIKAN ILMU KOMPUTER');
INSERT INTO `reference` VALUES ('156', null, 'major', 'PENDIDIKAN IPS', 'PENDIDIKAN IPS');
INSERT INTO `reference` VALUES ('157', null, 'major', 'PENDIDIKAN JASMANI, KESEHATAN DAN REKREASI', 'PENDIDIKAN JASMANI, KESEHATAN DAN REKREASI');
INSERT INTO `reference` VALUES ('158', null, 'major', 'PENDIDIKAN KEPELATIHAN OLAHRAGA', 'PENDIDIKAN KEPELATIHAN OLAHRAGA');
INSERT INTO `reference` VALUES ('159', null, 'major', 'PENDIDIKAN KESEJAHTERAAN KELUARGA', 'PENDIDIKAN KESEJAHTERAAN KELUARGA');
INSERT INTO `reference` VALUES ('160', null, 'major', 'PENDIDIKAN KIMIA', 'PENDIDIKAN KIMIA');
INSERT INTO `reference` VALUES ('161', null, 'major', 'PENDIDIKAN LUAR BIASA', 'PENDIDIKAN LUAR BIASA');
INSERT INTO `reference` VALUES ('162', null, 'major', 'PENDIDIKAN LUAR SEKOLAH', 'PENDIDIKAN LUAR SEKOLAH');
INSERT INTO `reference` VALUES ('163', null, 'major', 'PENDIDIKAN MANAJEMEN BISNIS', 'PENDIDIKAN MANAJEMEN BISNIS');
INSERT INTO `reference` VALUES ('164', null, 'major', 'PENDIDIKAN MANAJEMEN PERKANTORAN', 'PENDIDIKAN MANAJEMEN PERKANTORAN');
INSERT INTO `reference` VALUES ('165', null, 'major', 'PENDIDIKAN MATEMATIKA', 'PENDIDIKAN MATEMATIKA');
INSERT INTO `reference` VALUES ('166', null, 'major', 'PENDIDIKAN RESORT DAN LEISURE', 'PENDIDIKAN RESORT DAN LEISURE');
INSERT INTO `reference` VALUES ('167', null, 'major', 'PENDIDIKAN SEJARAH', 'PENDIDIKAN SEJARAH');
INSERT INTO `reference` VALUES ('168', null, 'major', 'PENDIDIKAN SENI MUSIK', 'PENDIDIKAN SENI MUSIK');
INSERT INTO `reference` VALUES ('169', null, 'major', 'PENDIDIKAN SENI RUPA DAN KERAJINAN', 'PENDIDIKAN SENI RUPA DAN KERAJINAN');
INSERT INTO `reference` VALUES ('170', null, 'major', 'PENDIDIKAN SENI TARI', 'PENDIDIKAN SENI TARI');
INSERT INTO `reference` VALUES ('171', null, 'major', 'PENDIDIKAN SOSILOGI', 'PENDIDIKAN SOSILOGI');
INSERT INTO `reference` VALUES ('172', null, 'major', 'PENDIDIKAN TATA BOGA', 'PENDIDIKAN TATA BOGA');
INSERT INTO `reference` VALUES ('173', null, 'major', 'PENDIDIKAN TATA BUSANA', 'PENDIDIKAN TATA BUSANA');
INSERT INTO `reference` VALUES ('174', null, 'major', 'PENDIDIKAN TEKNIK ARSITEKTUR', 'PENDIDIKAN TEKNIK ARSITEKTUR');
INSERT INTO `reference` VALUES ('175', null, 'major', 'PENDIDIKAN TEKNIK BANGUNAN', 'PENDIDIKAN TEKNIK BANGUNAN');
INSERT INTO `reference` VALUES ('176', null, 'major', 'PENDIDIKAN TEKNIK ELEKTRO', 'PENDIDIKAN TEKNIK ELEKTRO');
INSERT INTO `reference` VALUES ('177', null, 'major', 'Pendidikan Teknik Mesin', 'Pendidikan Teknik Mesin');
INSERT INTO `reference` VALUES ('178', null, 'major', 'Pendidikan Teknologi Agro Industri', 'Pendidikan Teknologi Agro Industri');
INSERT INTO `reference` VALUES ('179', null, 'major', 'Penyuluhan & Komunikasi Pertanian', 'Penyuluhan & Komunikasi Pertanian');
INSERT INTO `reference` VALUES ('180', null, 'major', 'Perencanaan Wilayah dan Kota', 'Perencanaan Wilayah dan Kota');
INSERT INTO `reference` VALUES ('181', null, 'major', 'Perikanan', 'Perikanan');
INSERT INTO `reference` VALUES ('182', null, 'major', 'Perpustakaan dan Informasi', 'Perpustakaan dan Informasi');
INSERT INTO `reference` VALUES ('183', null, 'major', 'PKN', 'PKN');
INSERT INTO `reference` VALUES ('184', null, 'major', 'Psikologi', 'Psikologi');
INSERT INTO `reference` VALUES ('185', null, 'major', 'Sastra Arab', 'Sastra Arab');
INSERT INTO `reference` VALUES ('186', null, 'major', 'Sastra Indonesia', 'Sastra Indonesia');
INSERT INTO `reference` VALUES ('187', null, 'major', 'Sastra Inggris', 'Sastra Inggris');
INSERT INTO `reference` VALUES ('188', null, 'major', 'Sastra Jepang', 'Sastra Jepang');
INSERT INTO `reference` VALUES ('189', null, 'major', 'Sastra Jerman', 'Sastra Jerman');
INSERT INTO `reference` VALUES ('190', null, 'major', 'Sastra Perancis', 'Sastra Perancis');
INSERT INTO `reference` VALUES ('191', null, 'major', 'Sastra Rusia', 'Sastra Rusia');
INSERT INTO `reference` VALUES ('192', null, 'major', 'Sastra Sunda', 'Sastra Sunda');
INSERT INTO `reference` VALUES ('193', null, 'major', 'Sos.ek. Pertanian (Agrobisnis)', 'Sos.ek. Pertanian (Agrobisnis)');
INSERT INTO `reference` VALUES ('194', null, 'major', 'Sosiologi', 'Sosiologi');
INSERT INTO `reference` VALUES ('195', null, 'major', 'Statistika', 'Statistika');
INSERT INTO `reference` VALUES ('196', null, 'major', 'Teknik Arsitektur', 'Teknik Arsitektur');
INSERT INTO `reference` VALUES ('197', null, 'major', 'Teknik Elektro', 'Teknik Elektro');
INSERT INTO `reference` VALUES ('198', null, 'major', 'Teknik Geodesi', 'Teknik Geodesi');
INSERT INTO `reference` VALUES ('199', null, 'major', 'Teknik Geologi', 'Teknik Geologi');
INSERT INTO `reference` VALUES ('200', null, 'major', 'Teknik Industri ', 'Teknik Industri ');
INSERT INTO `reference` VALUES ('201', null, 'major', 'Teknik Informatika', 'Teknik Informatika');
INSERT INTO `reference` VALUES ('202', null, 'major', 'Teknik Kimia', 'Teknik Kimia');
INSERT INTO `reference` VALUES ('203', null, 'major', 'Teknik Mesin', 'Teknik Mesin');
INSERT INTO `reference` VALUES ('204', null, 'major', 'Teknik Nuklir', 'Teknik Nuklir');
INSERT INTO `reference` VALUES ('205', null, 'major', 'Teknik Pertanian', 'Teknik Pertanian');
INSERT INTO `reference` VALUES ('206', null, 'major', 'Teknik Sipil', 'Teknik Sipil');
INSERT INTO `reference` VALUES ('207', null, 'major', 'Teknologi Hasil Perikanan', 'Teknologi Hasil Perikanan');
INSERT INTO `reference` VALUES ('208', null, 'major', 'Teknologi Industri Pertanian', 'Teknologi Industri Pertanian');
INSERT INTO `reference` VALUES ('209', null, 'major', 'Teknologi Informasi ', 'Teknologi Informasi ');
INSERT INTO `reference` VALUES ('210', null, 'major', 'Teknologi Pangan', 'Teknologi Pangan');
INSERT INTO `reference` VALUES ('211', null, 'major', 'Teknologi Pangan & Hasil Pertanian', 'Teknologi Pangan & Hasil Pertanian');
INSERT INTO `reference` VALUES ('212', null, 'major', 'Teknologi Pendidikan', 'Teknologi Pendidikan');
INSERT INTO `reference` VALUES ('213', null, 'major', 'other', 'other');
INSERT INTO `reference` VALUES ('214', null, 'industry', 'Construction & industrial', 'Construction & industrial');
INSERT INTO `reference` VALUES ('215', null, 'industry', 'Military', 'Militer');
INSERT INTO `reference` VALUES ('216', null, 'industry', 'Health', 'Health');
INSERT INTO `reference` VALUES ('217', null, 'province', 'DKI Jakarta', 'DKI Jakarta');
INSERT INTO `reference` VALUES ('218', null, 'province', 'Jawa Barat', 'Jawa Barat');
INSERT INTO `reference` VALUES ('219', null, 'province', 'Aceh ', 'Aceh ');
INSERT INTO `reference` VALUES ('220', null, 'province', 'Bali', 'Bali');
INSERT INTO `reference` VALUES ('221', null, 'province', 'Banten', 'Banten');
INSERT INTO `reference` VALUES ('222', null, 'province', 'Bengkulu', 'Bengkulu');
INSERT INTO `reference` VALUES ('223', null, 'province', 'Gorontalo', 'Gorontalo');
INSERT INTO `reference` VALUES ('224', null, 'province', 'Jambi', 'Jambi');
INSERT INTO `reference` VALUES ('225', null, 'province', 'Jawa Tengah', 'Jawa Tengah');
INSERT INTO `reference` VALUES ('226', null, 'province', 'Jawa Timur', 'Jawa Timur');
INSERT INTO `reference` VALUES ('227', null, 'province', 'Kalimantan Barat', 'Kalimantan Barat');
INSERT INTO `reference` VALUES ('228', null, 'province', 'Kalimantan Selatan', 'Kalimantan Selatan');
INSERT INTO `reference` VALUES ('229', null, 'province', 'Kalimantan Tengah', 'Kalimantan Tengah');
INSERT INTO `reference` VALUES ('230', null, 'province', 'Kalimantan Timur', 'Kalimantan Timur');
INSERT INTO `reference` VALUES ('231', null, 'province', 'Kalimantan Utara', 'Kalimantan Utara');
INSERT INTO `reference` VALUES ('232', null, 'province', 'Kepulauan Bangka Belitung', 'Kepulauan Bangka Belitung');
INSERT INTO `reference` VALUES ('233', null, 'province', 'Kepulauan Riau', 'Kepulauan Riau');
INSERT INTO `reference` VALUES ('234', null, 'province', 'Lampung', 'Lampung');
INSERT INTO `reference` VALUES ('235', null, 'province', 'Maluku', 'Maluku');
INSERT INTO `reference` VALUES ('236', null, 'province', 'Maluku Utara', 'Maluku Utara');
INSERT INTO `reference` VALUES ('237', null, 'province', 'Nusa Tenggara Barat', 'Nusa Tenggara Barat');
INSERT INTO `reference` VALUES ('238', null, 'province', 'Nusa Tenggara Timur', 'Nusa Tenggara Timur');
INSERT INTO `reference` VALUES ('239', null, 'province', 'Papua', 'Papua');
INSERT INTO `reference` VALUES ('240', null, 'province', 'Papua Barat', 'Papua Barat');
INSERT INTO `reference` VALUES ('241', null, 'province', 'Riau', 'Riau');
INSERT INTO `reference` VALUES ('242', null, 'province', 'Sulawesi Barat', 'Sulawesi Barat');
INSERT INTO `reference` VALUES ('243', null, 'province', 'Sulawesi Selatan', 'Sulawesi Selatan');
INSERT INTO `reference` VALUES ('244', null, 'province', 'Sulawesi Tengah', 'Sulawesi Tengah');
INSERT INTO `reference` VALUES ('245', null, 'province', 'Sulawsei Tenggara', 'Sulawsei Tenggara');
INSERT INTO `reference` VALUES ('246', null, 'province', 'Sulawesi Utara', 'Sulawesi Utara');
INSERT INTO `reference` VALUES ('247', null, 'province', 'Sumatera Barat', 'Sumatera Barat');
INSERT INTO `reference` VALUES ('248', null, 'province', 'Sumatera Selatan', 'Sumatera Selatan');
INSERT INTO `reference` VALUES ('249', null, 'province', 'Sumatera Utara', 'Sumatera Utara');
INSERT INTO `reference` VALUES ('250', null, 'province', 'Yogyakarta', 'Yogyakarta');
INSERT INTO `reference` VALUES ('251', null, 'province', 'Other', 'Other');
INSERT INTO `reference` VALUES ('252', null, 'city', 'Ambon', 'Ambon');
INSERT INTO `reference` VALUES ('253', null, 'city', 'Banda Aceh', 'Banda Aceh');
INSERT INTO `reference` VALUES ('254', null, 'city', 'Bandar Lampung', 'Bandar Lampung');
INSERT INTO `reference` VALUES ('255', null, 'city', 'Bandung', 'Bandung');
INSERT INTO `reference` VALUES ('256', null, 'city', 'Banjarmasin', 'Banjarmasin');
INSERT INTO `reference` VALUES ('257', null, 'city', 'Bengkulu', 'Bengkulu');
INSERT INTO `reference` VALUES ('258', null, 'city', 'Dendapar', 'Dendapar');
INSERT INTO `reference` VALUES ('259', null, 'city', 'Gorontalo', 'Gorontalo');
INSERT INTO `reference` VALUES ('260', null, 'city', 'Jakarta Barat', 'Jakarta Barat');
INSERT INTO `reference` VALUES ('261', null, 'city', 'Jakarta Timur', 'Jakarta Timur');
INSERT INTO `reference` VALUES ('262', null, 'city', 'Jakarta Utara', 'Jakarta Utara');
INSERT INTO `reference` VALUES ('263', null, 'city', 'Jakarta Selatan', 'Jakarta Selatan');
INSERT INTO `reference` VALUES ('264', null, 'city', 'Jambi', 'Jambi');
INSERT INTO `reference` VALUES ('265', null, 'city', 'Jayapura', 'Jayapura');
INSERT INTO `reference` VALUES ('266', null, 'city', 'Kendari', 'Kendari');
INSERT INTO `reference` VALUES ('267', null, 'city', 'Kupang', 'Kupang');
INSERT INTO `reference` VALUES ('268', null, 'city', 'Makasar', 'Makasar');
INSERT INTO `reference` VALUES ('269', null, 'city', 'Mamuju', 'Mamuju');
INSERT INTO `reference` VALUES ('270', null, 'city', 'Manado', 'Manado');
INSERT INTO `reference` VALUES ('271', null, 'city', 'Manokmari', 'Manokmari');
INSERT INTO `reference` VALUES ('272', null, 'city', 'Mataram', 'Mataram');
INSERT INTO `reference` VALUES ('273', null, 'city', 'Padang ', 'Padang ');
INSERT INTO `reference` VALUES ('274', null, 'city', 'Palangkaraya', 'Palangkaraya');
INSERT INTO `reference` VALUES ('275', null, 'city', 'Palembang', 'Palembang');
INSERT INTO `reference` VALUES ('276', null, 'city', 'Palu', 'Palu');
INSERT INTO `reference` VALUES ('277', null, 'city', 'Pangkjal Pinang', 'Pangkjal Pinang');
INSERT INTO `reference` VALUES ('278', null, 'city', 'Pekanbaru', 'Pekanbaru');
INSERT INTO `reference` VALUES ('279', null, 'city', 'Pontianak', 'Pontianak');
INSERT INTO `reference` VALUES ('280', null, 'city', 'Samarinda', 'Samarinda');
INSERT INTO `reference` VALUES ('281', null, 'city', 'Semarang', 'Semarang');
INSERT INTO `reference` VALUES ('282', null, 'city', 'Serang', 'Serang');
INSERT INTO `reference` VALUES ('283', null, 'city', 'Sofifi', 'Sofifi');
INSERT INTO `reference` VALUES ('284', null, 'city', 'Surabaya', 'Surabaya');
INSERT INTO `reference` VALUES ('285', null, 'city', 'Tanjung Pinang', 'Tanjung Pinang');
INSERT INTO `reference` VALUES ('286', null, 'city', 'Tanjung Selor', 'Tanjung Selor');
INSERT INTO `reference` VALUES ('287', null, 'city', 'Yogyakarta', 'Yogyakarta');
INSERT INTO `reference` VALUES ('288', null, 'city', 'Other', 'Other');

-- ----------------------------
-- Table structure for upload
-- ----------------------------
DROP TABLE IF EXISTS `upload`;
CREATE TABLE `upload` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upload>profile(profile_id)` (`profile_id`),
  CONSTRAINT `upload>profile(profile_id)` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of upload
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `validation_code` varchar(10) DEFAULT NULL,
  `status_id` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username,status` (`username`,`status_id`),
  KEY `user>reference(status)` (`status_id`),
  CONSTRAINT `user>reference(status)` FOREIGN KEY (`status_id`) REFERENCES `reference` (`reference_key`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'renowijoyo@gmail.comdsd', 'reno', '4692', 'validated', '2014-09-08');
INSERT INTO `user` VALUES ('2', 'renowijoydadsao@gmail.com', 'reno', '5528', 'validated', '2014-09-08');
INSERT INTO `user` VALUES ('3', 'renowijdoyo@gmail.com', 'reno', '2303', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('4', 'renodswijoyo@gmail.com', 'reno', '7990', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('5', 'renowijoysaso@gmail.com', 'reno', '0317', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('6', 'renowibvjoyo@gmail.com', 'reno', '9695', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('7', 'renowijosayo@gmail.com', 'reno', '5134', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('8', 'renowddijoyo@gmail.com', 'reno', '4653', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('9', 'renowsaaaijoyo@gmail.com', 'reno', '7379', 'validated', '2014-09-08');
INSERT INTO `user` VALUES ('10', 'fdf', 'reno', '6597', 'unvalidated', '2014-09-08');
INSERT INTO `user` VALUES ('11', 'ffss', 'reno', '1989', 'validated', '2014-09-08');
INSERT INTO `user` VALUES ('12', 'renowidssssjoyo@gmail.com', 'reno', '8733', 'validated', '2014-09-09');
INSERT INTO `user` VALUES ('13', 'rendddowijoyo@gmail.com', 'reno', '7559', 'unvalidated', '2014-09-09');
INSERT INTO `user` VALUES ('14', 'renowijoyo@gmail.com', 'reno', '4969', 'validated', '2014-09-09');

-- ----------------------------
-- Table structure for workhistory
-- ----------------------------
DROP TABLE IF EXISTS `workhistory`;
CREATE TABLE `workhistory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) DEFAULT NULL,
  `employer` varchar(255) DEFAULT NULL,
  `industry_id` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `profile_id_work` (`profile_id`),
  CONSTRAINT `profile_id_work` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of workhistory
-- ----------------------------
