<?php
	$db_users = array(
				'admin' => '123456',
		);

	$rooms_arr = array(
				1 => array('name'=>'大会议室', 'position'=>'A区域进门第一间', 'type'=>'A'),
				2 => array('name'=>'中型会议室', 'position'=>'A区域市场部边上', 'type'=>'A'),
				3 => array('name'=>'敞开式会议室', 'position'=>'A区域书吧边上', 'type'=>'A'),
				4 => array('name'=>'小型会议室(1)', 'position'=>'B区域进门第一间', 'type'=>'B'),
				5 => array('name'=>'小型会议室(2)', 'position'=>'B区域进门第二间', 'type'=>'B'),
				6 => array('name'=>'小型会议室(3)', 'position'=>'B区域进门第三间', 'type'=>'B'),
				7 => array('name'=>'中型会议室', 'position'=>'B区域机房斜对面', 'type'=>'B')
		);

	$time_arr = array(
				1 => array('start'=>'09:00', 'end'=>'10:00', 'type'=>'morning'),
				2 => array('start'=>'10:00', 'end'=>'11:00', 'type'=>'morning'),
				3 => array('start'=>'11:00', 'end'=>'12:00', 'type'=>'morning'),
				4 => array('start'=>'12:00', 'end'=>'13:30', 'type'=>'midday'),
				5 => array('start'=>'14:00', 'end'=>'15:00', 'type'=>'afterning'),
				6 => array('start'=>'15:00', 'end'=>'16:00', 'type'=>'afterning'),
				7 => array('start'=>'16:00', 'end'=>'17:00', 'type'=>'afterning'),
				8 => array('start'=>'17:00', 'end'=>'18:00', 'type'=>'afterning'),
				9 => array('start'=>'18:00', 'end'=>'19:00', 'type'=>'night'),
				10 => array('start'=>'19:00', 'end'=>'', 'type'=>'night'),
		);

	$hour_arr	= array('09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22');
	$minute_arr = array('00', '30');
	
	$room_type_a = "A";
	$room_type_b = "B";
	$time_slice	 = '12:30';

	$future_days	 = 7;

	$time_pre = array(
				'morning'	=> '上午',
				'midday'	=> '中午',
				'afterning' => '下午',
				'night'		=> '晚上'
		);
	
	$db_config = array(
					'server' => 'localhost',
					'port' => '3306',
					'user' => 'root',
					'pass' => '123456',
					'database' => 'project',
					'table' => 'bd_meeting_scheduled',
			);
?>