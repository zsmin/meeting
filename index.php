<?php
	$view = 'index';
	require_once("global.php");
	
	$action = $_GET['act'];
	$current_day = $_GET['day'];
	if ( $action ) {
		switch($action){
			case 'add' :
				$name = $_POST['name'];
				$room = $_POST['room'];
				$start = $_POST['start'];
				$end = $_POST['end'];

				setcookie("meeting_name", $name, time()+60*60*24*30 );		//设置为30天有效期

				if ( $start == $end ) {
					echo 'same_err';
					exit;
				}
				
				if ( $start ) $start .= ':00';
				if ( $end ) $end .= ':00';

				$room_date = substr( $start, 0, 10 );

				$link = mysql_connect($db_config['server'], $db_config['user'], $db_config['pass'])
					or die("Could not connect: " . mysql_error());
				mysql_query("SET NAMES 'UTF8'");
				mysql_select_db( $db_config['database'], $link );

				$sql_ck = "select id from boc_meeting_scheduled where room_no=$room and ( ('$start'>=start_time and '$end'<=end_time) or ('$start'<=start_time and '$end'>start_time) or ('$start'<end_time and '$end'>=end_time) or ('$start'<=start_time and '$end'>=end_time) )";

				$r = mysql_query($sql_ck);
				$r = mysql_fetch_row($r);

				if ( $r && $r[0] ) {
					echo 'conflict_err';
					exit;
				}

				$sql = "insert into boc_meeting_scheduled (name, room_no, room_date, start_time, end_time, display) values('$name', $room, '$room_date', '$start', '$end', 'T')";

				$r = mysql_query($sql);

				echo $r ? 'succ' : 'fail';

				mysql_close($link);
				exit;
				break;
			case 'show':
				break;
		}
	}

	$timestamp = time();
	$output['today'] = date("Y-m-d", $timestamp);
	$output['timestamp'] = $timestamp;
	$output['future_days'] = $future_days;

	if ( empty($current_day) ) $current_day = $output['today'];
	$output['current_day'] = $current_day;

	$sql = "select * from boc_meeting_scheduled where room_date='$current_day' and display='T'";

	$link = mysql_connect($db_config['server'], $db_config['user'], $db_config['pass'])
		or die("Could not connect: " . mysql_error());
	mysql_query("SET NAMES 'UTF8'");
	mysql_select_db( $db_config['database'], $link );
	$result = mysql_query($sql);
	
	$lists = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$room_no = $row['room_no'];

		$lists[$room_no][] = $row;
    }

	if ( $view ) require_once('./tpl/' . $view . '.php');

?>