-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_calendar_events_subscribe`
-- 

CREATE TABLE `tl_calendar_events_subscribe` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `id_member` int(10) unsigned NOT NULL default '0',
  `ces_referer` varchar(255) NOT NULL default 'CLUB',
  `ces_present` int(10) unsigned NOT NULL default '0',
  `ces_date` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `id_member` (`id_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_calendar_events`
-- 

CREATE TABLE `tl_calendar_events` (
  `register` char(1) NOT NULL default '',
  `lastDate` varchar(10) NOT NULL default '',
  `formId` int(10) unsigned NOT NULL default '0',
  `formHeadline` varchar(255) NOT NULL default '',  
  `sorting` int(10) unsigned NOT NULL default '0',
  `showFree` char(1) NOT NULL default '',
  `freeHeadline` varchar(255) NOT NULL default '',
  `max_register` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------
-- 
-- TABLES SYSTEM
-- 
-- --------------------------------------------------------
-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `xkn_event_sub_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

