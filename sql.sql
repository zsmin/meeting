CREATE TABLE `boc_meeting_scheduled` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '' COMMENT '预订人',
  `room_no` int(11) NOT NULL default '0' COMMENT '会议室编号',
  `room_date` varchar(10) NOT NULL default '0000-00-00' COMMENT '会议室使用日期',
  `start_time` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT '结束时间',
  `display` char(1) NOT NULL default 'T' COMMENT '是否删除(T:正常，F:删除)',
  PRIMARY KEY  (`id`),
  KEY `room_date` (`room_date`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='会议室预定';
