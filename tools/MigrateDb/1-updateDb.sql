
#
# Add MAPID fields
#
ALTER TABLE `oxdiscount` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxcategories` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxattribute` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxlinks` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxvoucherseries` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxmanufacturers` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxnews` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxselectlist` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxwrapping` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxdeliveryset` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxdelivery` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxvendor` ADD `OXMAPID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxobject2category` ADD `OXMAPID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);
ALTER TABLE `oxarticles` ADD `OXMAPID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Integer Mapping identifier' AFTER `OXID`, ADD INDEX (OXMAPID);


#
# Add mapping tables
#

# Adding large mapping tables (no index fields)
DROP TABLE IF EXISTS `oxarticles2shop`;
CREATE TABLE IF NOT EXISTS `oxarticles2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` bigint(20) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxcategories2shop`;
CREATE TABLE IF NOT EXISTS `oxcategories2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxobject2category2shop`;
CREATE TABLE IF NOT EXISTS `oxobject2category2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` bigint(20) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';

DROP TABLE IF EXISTS `oxmanufacturers2shop`;
CREATE TABLE IF NOT EXISTS `oxmanufacturers2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxvendor2shop`;
CREATE TABLE IF NOT EXISTS `oxvendor2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


#adding smaller mapping tables

DROP TABLE IF EXISTS `oxdiscount2shop`;
CREATE TABLE IF NOT EXISTS `oxdiscount2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxattribute2shop`;
CREATE TABLE IF NOT EXISTS `oxattribute2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxlinks2shop`;
CREATE TABLE IF NOT EXISTS `oxlinks2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxvoucherseries2shop`;
CREATE TABLE IF NOT EXISTS `oxvoucherseries2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxnews2shop`;
CREATE TABLE IF NOT EXISTS `oxnews2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxselectlist2shop`;
CREATE TABLE IF NOT EXISTS `oxselectlist2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxwrapping2shop`;
CREATE TABLE IF NOT EXISTS `oxwrapping2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxdeliveryset2shop`;
CREATE TABLE IF NOT EXISTS `oxdeliveryset2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';


DROP TABLE IF EXISTS `oxdelivery2shop`;
CREATE TABLE IF NOT EXISTS `oxdelivery2shop` (
  `OXMAPSHOPID` int(11) NOT NULL COMMENT 'Mapped shop id',
  `OXMAPOBJECTID` int(11) NOT NULL COMMENT 'Mapped object id',
  `OXMAPTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
  UNIQUE KEY `OXMAPIDX` (`OXMAPSHOPID`,`OXMAPOBJECTID`),
  KEY `OXMAPOBJECTID` (`OXMAPOBJECTID`),
  KEY `OXMAPSHOPID`   (`OXMAPSHOPID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 collate latin1_general_ci COMMENT='Mapping table for element subshop assignments';
