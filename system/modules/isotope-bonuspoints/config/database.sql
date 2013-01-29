-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_member`
-- 

CREATE TABLE `tl_member` (
  `iso_bonus_points` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_iso_bonuspoints`
--

CREATE TABLE `tl_iso_bonuspoints` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `type` varchar(64) NOT NULL default '',
  `minimum_total` decimal(12,2) NOT NULL default '0.00',
  `maximum_total` decimal(12,2) NOT NULL default '0.00',
  `points` int(10) unsigned NOT NULL default '0',
  `enabled` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_iso_products`
-- 

CREATE TABLE `tl_iso_products` (
  `bonus_points` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_iso_order_items`
--

CREATE TABLE `tl_iso_order_items` (
  `product_bonus_points` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_user`
-- 

CREATE TABLE `tl_user` (
 `iso_bonuspoints` blob NULL,
 `iso_bonuspointsp` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
