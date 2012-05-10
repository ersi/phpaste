CREATE TABLE IF NOT EXISTS `paste` (
  `pid` int(11) NOT NULL auto_increment,
  `poster` varchar(16) default NULL,
  `posted` datetime default NULL,
  `code` text,
  `parent_pid` int(11) default '0',
  `format` varchar(16) default NULL,
  `codefmt` mediumtext,
  `codecss` text,
  `expires` datetime default NULL,
  `expiry_flag` enum('d','m','f') NOT NULL default 'f',
  `password` varchar(250) default NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;