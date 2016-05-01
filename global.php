<?php
	header('Content-Type: text/html; charset=UTF-8');

	error_reporting(0);

	require_once('./config.php');

	$rooms_type_a_num = 0;
	foreach ( $rooms_arr as $room ) {
		if ( $room['type'] == $room_type_a ) $rooms_type_a_num ++;
	}
	$rooms_type_b_num = count($rooms_arr) - $rooms_type_a_num;

	$time_morning	= 0;
	$time_midday	= 0;
	$time_afterning = 0;
	$time_night		= 0;
	foreach( $time_arr as $tmp_time ) {
		switch( $tmp_time['type'] ){
			case 'morning' :
				$time_morning ++;
				break;
			case 'midday' :
				$time_midday ++;
				break;
			case 'afterning' :
				$time_afterning ++;
				break;
			case 'night' :
				$time_night ++;
				break;
		}
	}

	$output = array();

	$output['rooms_type_a_num'] = $rooms_type_a_num;
	$output['rooms_type_b_num'] = $rooms_type_b_num;
	$output['time_morning']		= $time_morning;
	$output['time_midday']		= $time_midday;
	$output['time_afterning']	= $time_afterning;
	$output['time_night']		= $time_night;

	$output['rooms_arr']		= $rooms_arr;
	$output['time_arr']			= $time_arr;
	$output['time_pre']			= $time_pre;
	
?>